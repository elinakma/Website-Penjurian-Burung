<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas_lomba_juri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('user_id'); // juri
            $table->timestamps();

            $table->foreign('kelas_id')
                  ->references('id_kelas')
                  ->on('kelas_lomba')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // Satu juri tidak boleh dobel di kelas yang sama
            $table->unique(['kelas_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas_lomba_juri');
    }
};