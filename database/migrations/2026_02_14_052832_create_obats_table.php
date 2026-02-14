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
    Schema::create('obats', function (Blueprint $table) {
        $table->id();
        $table->string('kd_obat')->unique();
        $table->string('nm_obat');
        $table->string('jenis');
        $table->string('satuan');
        $table->decimal('harga_beli', 15, 2);
        $table->decimal('harga_jual', 15, 2);
        $table->integer('stok')->default(0);

        $table->foreignId('kd_suplier')
              ->constrained('suppliers')
              ->onDelete('cascade');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
