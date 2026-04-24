<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // ===== MOODS =====
        DB::table('moods')->insert([
            ['nama_mood' => 'Senang',   'emoji' => '😊', 'warna' => '#a855f7'],
            ['nama_mood' => 'Sedih',    'emoji' => '😢', 'warna' => '#60a5fa'],
            ['nama_mood' => 'Marah',    'emoji' => '😠', 'warna' => '#f87171'],
            ['nama_mood' => 'Cemas',    'emoji' => '😰', 'warna' => '#fb923c'],
            ['nama_mood' => 'Netral',   'emoji' => '😐', 'warna' => '#94a3b8'],
            ['nama_mood' => 'Semangat', 'emoji' => '🔥', 'warna' => '#facc15'],
            ['nama_mood' => 'Lelah',    'emoji' => '😴', 'warna' => '#6b7280'],
        ]);

        // ===== KATEGORIS =====
        DB::table('kategoris')->insert([
            ['nama_kategori' => 'Pribadi'],
            ['nama_kategori' => 'Pekerjaan'],
            ['nama_kategori' => 'Kesehatan'],
            ['nama_kategori' => 'Hubungan'],
            ['nama_kategori' => 'Keuangan'],
            ['nama_kategori' => 'Pendidikan'],
        ]);

        // ===== ASPEKS =====
        DB::table('aspeks')->insert([
            ['nama_aspek' => 'Mental',    'warna' => '#a855f7'],
            ['nama_aspek' => 'Akademik',  'warna' => '#60a5fa'],
            ['nama_aspek' => 'Karir',     'warna' => '#34d399'],
            ['nama_aspek' => 'Sosial',    'warna' => '#fb923c'],
            ['nama_aspek' => 'Spiritual', 'warna' => '#facc15'],
            ['nama_aspek' => 'Fisik',     'warna' => '#f87171'],
        ]);
    }
}
