<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'pickup_method')) {
                $table->string('pickup_method')->nullable()->after('deadline');
            }

            if (! Schema::hasColumn('orders', 'design_file_status')) {
                $table->string('design_file_status')->nullable()->after('pickup_method');
            }
        });

        Schema::table('order_items', function (Blueprint $table) {
            if (! Schema::hasColumn('order_items', 'variant_name')) {
                $table->string('variant_name')->nullable()->after('product_name');
            }

            if (! Schema::hasColumn('order_items', 'finishing_name')) {
                $table->string('finishing_name')->nullable()->after('variant_name');
            }

            if (! Schema::hasColumn('order_items', 'size')) {
                $table->string('size')->nullable()->after('finishing_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'size')) {
                $table->dropColumn('size');
            }

            if (Schema::hasColumn('order_items', 'finishing_name')) {
                $table->dropColumn('finishing_name');
            }

            if (Schema::hasColumn('order_items', 'variant_name')) {
                $table->dropColumn('variant_name');
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'design_file_status')) {
                $table->dropColumn('design_file_status');
            }

            if (Schema::hasColumn('orders', 'pickup_method')) {
                $table->dropColumn('pickup_method');
            }
        });
    }
};
