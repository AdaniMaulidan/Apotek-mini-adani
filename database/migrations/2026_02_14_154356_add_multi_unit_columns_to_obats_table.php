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
        Schema::table('obats', function (Blueprint $table) {
            $table->renameColumn('satuan', 'satuan_besar');
            $table->renameColumn('harga_jual', 'harga_jual_besar');
            
            $table->string('satuan_menengah')->nullable()->after('nm_obat'); // nm_obat is before jenis, but let's put it near satuan_besar
        });

        Schema::table('obats', function (Blueprint $table) {
            $table->string('satuan_kecil')->default('Tablet')->after('satuan_besar');
            $table->integer('isi_menengah')->default(1)->after('satuan_kecil');
            $table->integer('isi_kecil')->default(1)->after('isi_menengah');
            $table->decimal('harga_jual_menengah', 15, 2)->default(0)->after('harga_jual_besar');
            $table->decimal('harga_jual_kecil', 15, 2)->default(0)->after('harga_jual_menengah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('obats', function (Blueprint $table) {
            $table->dropColumn(['satuan_menengah', 'satuan_kecil', 'isi_menengah', 'isi_kecil', 'harga_jual_menengah', 'harga_jual_kecil']);
            $table->renameColumn('satuan_besar', 'satuan');
            $table->renameColumn('harga_jual_besar', 'harga_jual');
        });
    }
};
