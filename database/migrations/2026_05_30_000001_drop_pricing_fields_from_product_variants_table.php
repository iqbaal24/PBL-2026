<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = collect(['price', 'weight', 'stock_status'])
            ->filter(fn (string $column) => Schema::hasColumn('product_variants', $column))
            ->all();

        if ($columns === []) {
            return;
        }

        Schema::table('product_variants', fn (Blueprint $table) => $table->dropColumn($columns));
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            if (! Schema::hasColumn('product_variants', 'price')) {
                $table->decimal('price', 12, 2)->default(0)->after('variant_name');
            }

            if (! Schema::hasColumn('product_variants', 'weight')) {
                $table->integer('weight')->nullable()->after('price');
            }

            if (! Schema::hasColumn('product_variants', 'stock_status')) {
                $table->boolean('stock_status')->default(true)->after('weight');
            }
        });
    }
};
