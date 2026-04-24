<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refleksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mood_id')->constrained()->onDelete('restrict');
            $table->foreignId('kategori_id')->constrained()->onDelete('restrict');
            $table->foreignId('aspek_id')->constrained()->onDelete('restrict');
            $table->string('judul');
            $table->text('isi_refleksi');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refleksis');
    }
};
