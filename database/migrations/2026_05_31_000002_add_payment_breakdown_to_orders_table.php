<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'shipping_fee')) {
                $table->unsignedBigInteger('shipping_fee')->default(0)->after('notes');
            }

            if (! Schema::hasColumn('orders', 'design_fee')) {
                $table->unsignedBigInteger('design_fee')->nullable()->after('shipping_fee');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'design_fee')) {
                $table->dropColumn('design_fee');
            }

            if (Schema::hasColumn('orders', 'shipping_fee')) {
                $table->dropColumn('shipping_fee');
            }
        });
    }
};
