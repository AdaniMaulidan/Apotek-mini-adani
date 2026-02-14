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
    Schema::create('penjualans', function (Blueprint $table) {
        $table->id();
        $table->string('nota')->unique();
        $table->date('tgl_nota');

        $table->foreignId('kd_pelanggan')
              ->constrained('pelanggans')
              ->onDelete('cascade');

        $table->decimal('diskon', 15, 2)->default(0);
        $table->decimal('total', 15, 2)->default(0);

        $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
