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
        Schema::create('kelas_lomba', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->string('nama');
            $table->unsignedInteger('harga');
            $table->unsignedInteger('kuota');
            $table->enum('status', ['pendaftaran', 'penilaian', 'selesai'])
                  ->default('pendaftaran');
            $table->timestamp('final_at')->nullable();

            // Foreign key ke tabel acaras
            $table->foreignId('acara_id')
                  ->constrained('acaras', 'id_acara')
                  ->onDelete('cascade');

            // Foreign key ke tabel jenis_burung
            $table->foreignId('burung_id')
                  ->constrained('jenis_burung')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_lomba');
    }
};