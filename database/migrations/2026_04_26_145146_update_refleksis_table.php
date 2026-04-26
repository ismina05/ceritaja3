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
        Schema::table('refleksis', function (Blueprint $table) {

            // Hapus foreign key dulu (cek biar aman)
            if (Schema::hasColumn('refleksis', 'mood_id')) {
                $table->dropForeign(['mood_id']);
            }
            if (Schema::hasColumn('refleksis', 'kategori_id')) {
                $table->dropForeign(['kategori_id']);
            }
            if (Schema::hasColumn('refleksis', 'aspek_id')) {
                $table->dropForeign(['aspek_id']);
            }

            // Hapus kolom lama
            $table->dropColumn([
                'mood_id',
                'kategori_id',
                'aspek_id',
                'judul',
                'isi_refleksi'
            ]);

            // Tambah kolom baru (free text sesuai konsep kamu)
            $table->text('emosi')->after('user_id');
            $table->text('mindset')->after('emosi');
            $table->text('tindakan')->after('mindset');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refleksis', function (Blueprint $table) {

            // Hapus kolom baru
            $table->dropColumn(['emosi', 'mindset', 'tindakan']);

            // (Opsional) Tambahkan kembali kolom lama kalau mau rollback full
            $table->unsignedBigInteger('mood_id')->nullable();
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->unsignedBigInteger('aspek_id')->nullable();
            $table->string('judul')->nullable();
            $table->text('isi_refleksi')->nullable();
        });
    }
};