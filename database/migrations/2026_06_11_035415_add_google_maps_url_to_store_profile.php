<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('store_profile', function (Blueprint $table) {
            if (!Schema::hasColumn('store_profile', 'maps_url')) {
                $table->text('maps_url')->nullable()->after('address');
            }
            if (!Schema::hasColumn('store_profile', 'maps_embed_url')) {
                $table->text('maps_embed_url')->nullable()->after('maps_url');
            }
        });

        DB::table('store_profile')
            ->whereNull('maps_url')
            ->update(['maps_url' => config('storefront.maps_url')]);

        DB::table('store_profile')
            ->whereNull('maps_embed_url')
            ->update(['maps_embed_url' => config('storefront.maps_embed_url')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_profile', function (Blueprint $table) {
            $table->dropColumn(['maps_url', 'maps_embed_url']);
        });
    }
};
