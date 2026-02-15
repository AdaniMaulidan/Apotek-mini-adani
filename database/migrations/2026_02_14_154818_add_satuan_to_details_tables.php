<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pembelian_details', function (Blueprint $table) {
            $table->string('satuan')->nullable()->after('jumlah');
        });

        Schema::table('penjualan_details', function (Blueprint $table) {
            $table->string('satuan')->nullable()->after('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelian_details', function (Blueprint $table) {
            $table->dropColumn('satuan');
        });

        Schema::table('penjualan_details', function (Blueprint $table) {
            $table->dropColumn('satuan');
        });
    }
};
