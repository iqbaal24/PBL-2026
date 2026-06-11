<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'product_variant_id')) {
                $table->dropConstrainedForeignId('product_variant_id');
            }

            if (Schema::hasColumn('order_items', 'product_finishing_id')) {
                $table->dropConstrainedForeignId('product_finishing_id');
            }

            if (Schema::hasColumn('order_items', 'variant_name')) {
                $table->dropColumn('variant_name');
            }

            if (Schema::hasColumn('order_items', 'finishing_name')) {
                $table->dropColumn('finishing_name');
            }
        });

        if (Schema::hasColumn('order_items', 'specification')) {
            DB::table('order_items')
                ->whereNull('specification')
                ->update(['specification' => '']);
        }

        Schema::table('order_items', function (Blueprint $table) {
            if (! Schema::hasColumn('order_items', 'general_notes')) {
                $table->text('general_notes')->nullable()->after('subtotal');
            }

            if (Schema::hasColumn('order_items', 'specification')) {
                $table->text('specification')->nullable(false)->change();
            }

            if (Schema::hasColumn('order_items', 'unit_price')) {
                $table->unsignedBigInteger('unit_price')->default(0)->change();
            }

            if (Schema::hasColumn('order_items', 'subtotal')) {
                $table->unsignedBigInteger('subtotal')->default(0)->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (! Schema::hasColumn('order_items', 'product_variant_id')) {
                $table->foreignId('product_variant_id')->nullable()->after('product_id')->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('order_items', 'product_finishing_id')) {
                $table->foreignId('product_finishing_id')->nullable()->after('product_variant_id')->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('order_items', 'variant_name')) {
                $table->string('variant_name')->nullable()->after('product_name');
            }

            if (! Schema::hasColumn('order_items', 'finishing_name')) {
                $table->string('finishing_name')->nullable()->after('variant_name');
            }

            if (Schema::hasColumn('order_items', 'unit_price')) {
                $table->decimal('unit_price', 12, 2)->nullable()->change();
            }

            if (Schema::hasColumn('order_items', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->nullable()->change();
            }

            if (Schema::hasColumn('order_items', 'specification')) {
                $table->text('specification')->nullable()->change();
            }

            if (Schema::hasColumn('order_items', 'general_notes')) {
                $table->dropColumn('general_notes');
            }
        });
    }
};
