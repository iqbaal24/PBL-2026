<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        ]);

        $order = Order::query()
            ->with([
                'items:id,order_id,product_id,product_name,variant_name,quantity,subtotal',
                'statusHistories:id,order_id,status,note,created_at',
            ])
            ->whereRaw('LOWER(order_code) = ?', [Str::lower(trim($formData['order_number']))])
            ->first();

        if (! $order) {
            return view('track-order', [
                'formData' => $formData,
                'lookupState' => 'error',
                'lookupError' => [
                    'title' => 'Pesanan tidak ditemukan',
                    'message' => 'Nomor pesanan tidak cocok. Periksa kembali lalu coba lagi.',
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

    public function receipt(Order $order)
    {
        $payload = $this->buildTrackingPayload($order->loadMissing([
            'items:id,order_id,product_id,product_name,variant_name,quantity,subtotal',
            'statusHistories:id,order_id,status,note,created_at',
        ]));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('receipt', [
            'payload' => $payload,
        ]);

        return $pdf->download('receipt-' . $payload['order_number'] . '.pdf');
    }

    public function storeReview(Request $request, Order $order)
    {
        $order->loadMissing([
            'items:id,order_id,product_id,product_name,variant_name,quantity,subtotal',
            'reviews:id,order_id,product_id',
            'statusHistories:id,order_id,status,note,created_at',
        ]);

        $formData = [
            'order_number' => $order->order_code,
        ];

        $reviewableProductIds = $order->items
            ->pluck('product_id')
            ->filter()
            ->unique()
            ->values();

        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'integer', Rule::in($reviewableProductIds->all())],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'product_id.required' => 'Pilih produk yang ingin diberi review.',
            'product_id.in' => 'Produk yang dipilih tidak ada di pesanan ini.',
            'rating.required' => 'Pilih rating terlebih dahulu.',
            'comment.min' => 'Tulis review minimal 10 karakter.',
        ]);

        if ($validator->fails()) {
            return view('track-order', [
                'formData' => $formData,
                'lookupState' => 'success',
                'lookupError' => null,
                'result' => $this->buildTrackingPayload($order),
                'reviewInput' => $request->only(['product_id', 'rating', 'comment']),
                'errors' => (new ViewErrorBag())->put('default', $validator->errors()),
            ]);
        }

        $validated = $validator->validated();

        $alreadyReviewed = $order->reviews()
            ->where('product_id', $validated['product_id'])
            ->exists();

        if ($alreadyReviewed) {
            $validator->errors()->add('product_id', 'Produk ini sudah pernah diberi review dari pesanan ini.');

            return view('track-order', [
                'formData' => $formData,
                'lookupState' => 'success',
                'lookupError' => null,
                'result' => $this->buildTrackingPayload($order),
                'reviewInput' => $request->only(['product_id', 'rating', 'comment']),
                'errors' => (new ViewErrorBag())->put('default', $validator->errors()),
            ]);
        }

        Review::create([
            'customer_name' => $order->customer_name,
            'order_id' => $order->id,
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_visible' => false,
        ]);

        return view('track-order', [
            'formData' => $formData,
            'lookupState' => 'success',
            'lookupError' => null,
            'result' => $this->buildTrackingPayload($order->refresh()->load([
                'items:id,order_id,product_id,product_name,variant_name,quantity,subtotal',
                'reviews:id,order_id,product_id',
                'statusHistories:id,order_id,status,note,created_at',
            ])),
            'reviewSuccess' => 'Terima kasih. Review Anda sudah terkirim dan akan dicek admin sebelum ditampilkan.',
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
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'variant_name' => $item->variant_name,
                'quantity' => $item->quantity,
                'subtotal' => (float) $item->subtotal,
            ];
        })->values()->all();

        $reviewedProductIds = $order->reviews
            ->pluck('product_id')
            ->filter()
            ->unique()
            ->values();

        $reviewableProducts = $order->items
            ->filter(fn ($item) => $item->product_id)
            ->groupBy('product_id')
            ->map(function ($items, $productId) use ($reviewedProductIds) {
                return [
                    'product_id' => (int) $productId,
                    'product_name' => $items->first()->product_name,
                    'variants' => $items->pluck('variant_name')->filter()->unique()->values()->implode(', '),
                    'has_review' => $reviewedProductIds->contains((int) $productId),
                ];
            })
            ->values()
            ->all();

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
            'reviewable_products' => $reviewableProducts,
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
}
