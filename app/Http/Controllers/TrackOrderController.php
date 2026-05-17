<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TrackOrderController extends Controller
{
    private const PUBLIC_STAGES = [
        'pending' => ['label' => 'Pending', 'description' => 'Pesanan tercatat dan menunggu proses berikutnya.'],
        'design' => ['label' => 'Proses Desain', 'description' => 'Tim sedang menyiapkan atau menyesuaikan desain pesanan Anda.'],
        'printing' => ['label' => 'Dicetak', 'description' => 'Pesanan sedang diproses di tahap produksi cetak.'],
        'completed' => ['label' => 'Selesai', 'description' => 'Pesanan selesai dan siap diambil.'],
    ];

    public function index()
    {
        return view('track-order', [
            'formData' => [
                'order_number' => '',
                'whatsapp_number' => '',
            ],
            'lookupState' => null,
            'lookupError' => null,
            'result' => null,
        ]);
    }

    public function show(Request $request)
    {
        $formData = $request->validate([
            'order_number' => ['required', 'string', 'max:255'],
            'whatsapp_number' => ['required', 'string', 'max:30'],
        ]);

        $order = Order::query()
            ->with([
                'items:id,order_id,product_name,variant_name,quantity,subtotal',
                'statusHistories:id,order_id,status,note,created_at',
            ])
            ->whereRaw('LOWER(order_code) = ?', [Str::lower(trim($formData['order_number']))])
            ->first();

        if (! $order || ! $this->phonesMatch($order->customer_phone, $formData['whatsapp_number'])) {
            return view('track-order', [
                'formData' => $formData,
                'lookupState' => 'error',
                'lookupError' => [
                    'title' => 'Pesanan tidak ditemukan',
                    'message' => 'Nomor pesanan atau nomor WhatsApp tidak cocok. Periksa kembali lalu coba lagi.',
                ],
                'result' => null,
            ]);
        }

        return view('track-order', [
            'formData' => $formData,
            'lookupState' => 'success',
            'lookupError' => null,
            'result' => $this->buildTrackingPayload($order),
        ]);
    }

    public function receipt(Request $request, Order $order): Response
    {
        $validated = $request->validate([
            'wa' => ['required', 'string', 'max:30'],
        ]);

        abort_unless($this->phonesMatch($order->customer_phone, $validated['wa']), 404);

        $payload = $this->buildTrackingPayload($order->loadMissing([
            'items:id,order_id,product_name,variant_name,quantity,subtotal',
            'statusHistories:id,order_id,status,note,created_at',
        ]));

        $lines = [
            'Harapan Jaya Printing',
            'Digital Receipt',
            '',
            'Order Number: ' . $payload['order_number'],
            'Customer WA: ' . $payload['whatsapp'],
            'Current Status: ' . $payload['current_status']['label'],
            'Last Update: ' . $payload['last_updated'],
            '',
            'Product Summary:',
        ];

        foreach ($payload['items'] as $item) {
            $lines[] = sprintf(
                '- %s | %s | Qty %d',
                $item['product_name'],
                $item['variant_name'],
                $item['quantity']
            );
        }

        $lines[] = '';
        $lines[] = 'Production Timeline:';

        foreach ($payload['timeline'] as $step) {
            $prefix = match ($step['state']) {
                'done' => '[x]',
                'current' => '[>]',
                'exception' => '[!]',
                default => '[ ]',
            };

            $lines[] = $prefix . ' ' . $step['label'] . ' - ' . $step['description'];
        }

        $pdf = $this->renderSimplePdf($lines);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="receipt-' . $payload['order_number'] . '.pdf"',
            'Content-Length' => strlen($pdf),
        ]);
    }

    private function buildTrackingPayload(Order $order): array
    {
        $histories = $order->statusHistories
            ->sortBy('created_at')
            ->values();

        $timeline = $this->buildTimeline($order->status, $histories);
        $currentStep = collect($timeline)->firstWhere('state', 'current')
            ?? collect($timeline)->firstWhere('state', 'exception')
            ?? collect($timeline)->last();

        $items = $order->items->map(function ($item) {
            return [
                'product_name' => $item->product_name,
                'variant_name' => $item->variant_name,
                'quantity' => $item->quantity,
                'subtotal' => (float) $item->subtotal,
            ];
        })->values()->all();

        return [
            'id' => $order->id,
            'order_number' => $order->order_code,
            'whatsapp' => $order->customer_phone,
            'current_status' => [
                'label' => $currentStep['label'],
                'description' => $currentStep['description'],
                'tone' => $currentStep['tone'],
            ],
            'last_updated' => $this->formatDateTime($histories->last()?->created_at ?? $order->updated_at),
            'items' => $items,
            'timeline' => $timeline,
        ];
    }

    private function buildTimeline(string $currentStatus, Collection $histories): array
    {
        $normalizedHistory = $histories
            ->map(fn ($history) => $this->normalizeStatus($history->status))
            ->filter()
            ->unique()
            ->values();

        $current = $this->normalizeStatus($currentStatus);

        if (in_array($current, ['canceled', 'attention'], true)) {
            return [
                ...$this->baseTimeline($normalizedHistory, null),
                [
                    'key' => $current,
                    'label' => $current === 'canceled' ? 'Dibatalkan' : 'Perlu Perhatian',
                    'description' => $current === 'canceled'
                        ? 'Pesanan dibatalkan. Silakan hubungi tim kami bila Anda membutuhkan bantuan lanjutan.'
                        : 'Pesanan memerlukan konfirmasi tambahan dari tim kami.',
                    'state' => 'exception',
                    'tone' => $current === 'canceled' ? 'danger' : 'warning',
                ],
            ];
        }

        return $this->baseTimeline($normalizedHistory, $current);
    }

    private function baseTimeline(Collection $normalizedHistory, ?string $current): array
    {
        $stages = array_keys(self::PUBLIC_STAGES);
        $currentIndex = $current ? array_search($current, $stages, true) : null;

        return collect($stages)->map(function ($key, $index) use ($normalizedHistory, $currentIndex) {
            $meta = self::PUBLIC_STAGES[$key];
            $state = 'upcoming';

            if ($normalizedHistory->contains($key) || ($currentIndex !== null && $index < $currentIndex)) {
                $state = 'done';
            }

            if ($currentIndex !== null && $index === $currentIndex) {
                $state = 'current';
            }

            return [
                'key' => $key,
                'label' => $meta['label'],
                'description' => $meta['description'],
                'state' => $state,
                'tone' => $state === 'current' ? 'accent' : 'neutral',
            ];
        })->all();
    }

    private function normalizeStatus(?string $status): ?string
    {
        return match (Str::lower((string) $status)) {
            'pending', 'created', 'new', 'paid' => 'pending',
            'confirmed', 'design', 'designing', 'proses desain', 'design_review' => 'design',
            'printing', 'dicetak', 'production', 'produksi' => 'printing',
            'ready', 'completed', 'done', 'ready_pickup', 'pickup_ready', 'selesai', 'delivered' => 'completed',
            'cancelled', 'canceled' => 'canceled',
            'attention', 'needs_attention', 'hold', 'problem' => 'attention',
            default => null,
        };
    }

    private function formatDateTime(mixed $value): string
    {
        if ($value instanceof Carbon) {
            return $value->translatedFormat('d M Y, H:i');
        }

        if (is_string($value) && $value !== '') {
            return Carbon::parse($value)->translatedFormat('d M Y, H:i');
        }

        return '-';
    }

    private function phonesMatch(string $storedPhone, string $submittedPhone): bool
    {
        return $this->normalizePhone($storedPhone) === $this->normalizePhone($submittedPhone);
    }

    private function normalizePhone(string $value): string
    {
        return ltrim(preg_replace('/\D+/', '', $value) ?? '', '0');
    }

    private function renderSimplePdf(array $lines): string
    {
        $escapedLines = array_map(function ($line) {
            return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $line);
        }, $lines);

        $stream = "BT\n/F1 12 Tf\n50 790 Td\n14 TL\n";

        foreach ($escapedLines as $index => $line) {
            if ($index === 0) {
                $stream .= '(' . $line . ") Tj\n";
                continue;
            }

            $stream .= 'T* (' . $line . ") Tj\n";
        }

        $stream .= "ET";

        $objects = [
            "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj",
            "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj",
            "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj",
            "4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj",
            "5 0 obj << /Length " . strlen($stream) . " >> stream\n" . $stream . "\nendstream endobj",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object . "\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        foreach ($offsets as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        $pdf .= "trailer << /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n" . $xrefOffset . "\n%%EOF";

        return $pdf;
    }
}
