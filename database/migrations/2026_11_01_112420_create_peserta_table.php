<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('kelas_lomba_id');
            $table->unsignedBigInteger('acara_id');
            $table->unsignedBigInteger('burung_id');
            $table->string('nama_burung');
            $table->text('alamat');
            $table->integer('harga');
            $table->unsignedInteger('nomor_gantangan')->nullable();
            $table->string('status')->default('menunggu_pembayaran'); // menunggu_pembayaran, lunas, ditolak
            $table->timestamps();

            // Foreign keys
            $table->foreign('kelas_lomba_id')
                  ->references('id_kelas')
                  ->on('kelas_lomba')
                  ->onDelete('cascade');

            $table->foreign('acara_id')
                  ->references('id_acara')
                  ->on('acaras')
                  ->onDelete('cascade');

            $table->foreign('burung_id')
                  ->references('id')
                  ->on('jenis_burung')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};