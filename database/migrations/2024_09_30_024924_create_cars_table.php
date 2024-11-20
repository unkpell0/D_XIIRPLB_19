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
        Schema::create('cars', function (Blueprint $table) {
            $table->id(); // Ini secara otomatis auto increment dan primary key
            $table->string('nama');
            $table->string('jenis');
            $table->string('merek');
            $table->string('tipe');
            $table->char('plat_nomor', length:10);
            $table->year('tahun_produksi');
            $table->string('image');
            $table->string('status')->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
