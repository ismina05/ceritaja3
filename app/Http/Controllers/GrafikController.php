<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Refleksi;
use Carbon\Carbon;

class GrafikController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // ===== STATS =====
        $totalRefleksi = Refleksi::where('user_id', $userId)->count();

        $bulanIni = Refleksi::where('user_id', $userId)
                        ->whereMonth('tanggal', now()->month)
                        ->whereYear('tanggal', now()->year)
                        ->count();

        $streak = $this->hitungStreak($userId);

        // Emosi dominan — ambil kata pertama yang paling sering muncul
        $emosiDominan = $this->emosiDominan($userId);

        // ===== TREN CHART =====
        $tren = [
            'minggu' => $this->trenMinggu($userId),
            'bulan'  => $this->trenBulan($userId),
            'tahun'  => $this->trenTahun($userId),
        ];

        // ===== DISTRIBUSI EMOSI (word frequency) =====
        $emosiData = $this->emosiFrequency($userId);

        // ===== INSIGHT =====
        $pola_emosi        = $this->insightEmosi($emosiDominan, $userId, $totalRefleksi);
        $pola_aspek        = $this->insightMindset($userId);
        $pola_konsistensi  = $this->insightKonsistensi($userId, $streak, $bulanIni);
        $analisis_mendalam = $this->analisismendalam($userId, $totalRefleksi, $emosiDominan, $streak);

        $chartData = [
            'tren'  => $tren,
            'emosi' => $emosiData,
        ];

        return view('grafik.index', compact(
            'totalRefleksi', 'bulanIni', 'streak', 'emosiDominan',
            'chartData', 'pola_emosi', 'pola_aspek', 'pola_konsistensi', 'analisis_mendalam'
        ));
    }

    // ── STREAK ──────────────────────────────────────────────
    private function hitungStreak($userId)
    {
        $streak = 0;
        $date   = Carbon::today();

        while (true) {
            $ada = Refleksi::where('user_id', $userId)
                    ->whereDate('tanggal', $date->toDateString())
                    ->exists();
            if (!$ada) break;
            $streak++;
            $date->subDay();
        }

        return $streak;
    }

    // ── TREN ────────────────────────────────────────────────
    private function trenMinggu($userId)
    {
        $labels = [];
        $data   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date     = Carbon::now()->subDays($i);
            $labels[] = $date->translatedFormat('D');
            $data[]   = Refleksi::where('user_id', $userId)
                            ->whereDate('tanggal', $date->toDateString())
                            ->count();
        }
        return ['labels' => $labels, 'data' => $data];
    }

    private function trenBulan($userId)
    {
        $labels      = [];
        $data        = [];
        $daysInMonth = now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = (string) $i;
            $data[]   = Refleksi::where('user_id', $userId)
                            ->whereYear('tanggal', now()->year)
                            ->whereMonth('tanggal', now()->month)
                            ->whereDay('tanggal', $i)
                            ->count();
        }
        return ['labels' => $labels, 'data' => $data];
    }

    private function trenTahun($userId)
    {
        $labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
        $data   = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = Refleksi::where('user_id', $userId)
                        ->whereYear('tanggal', now()->year)
                        ->whereMonth('tanggal', $i)
                        ->count();
        }
        return ['labels' => $labels, 'data' => $data];
    }

    // ── ANALISIS TEKS BEBAS ─────────────────────────────────

    /**
     * Hitung frekuensi kata pada kolom emosi
     * — buang stopword pendek, ambil top 8
     */
    private function emosiFrequency($userId)
    {
        $stopwords = ['dan','di','ke','dari','yang','aku','tapi','tapi','juga',
                      'sudah','saya','ini','itu','dengan','untuk','ada','tidak',
                      'atau','pada','se','karena','masih','bisa','lebih','sangat',
                      'jadi','lagi','hari','waktu','saat','tapi','pun','karena'];

        $rows  = Refleksi::where('user_id', $userId)->pluck('emosi');
        $freq  = [];

        foreach ($rows as $text) {
            $words = preg_split('/[\s,;.!?]+/', mb_strtolower($text), -1, PREG_SPLIT_NO_EMPTY);
            foreach ($words as $word) {
                if (mb_strlen($word) < 3) continue;
                if (in_array($word, $stopwords)) continue;
                $freq[$word] = ($freq[$word] ?? 0) + 1;
            }
        }

        arsort($freq);
        $top = array_slice($freq, 0, 8, true);

        $colors = ['#7b52d4','#a78bfa','#f59e0b','#10b981','#ef4444','#3b82f6','#ec4899','#14b8a6'];
        $result = [];
        $i = 0;
        foreach ($top as $word => $count) {
            $result[] = [
                'label' => $word,
                'value' => $count,
                'color' => $colors[$i % count($colors)],
            ];
            $i++;
        }

        return $result;
    }

    /**
     * Ambil kata emosi yang paling sering disebut
     */
    private function emosiDominan($userId)
    {
        $data = $this->emosiFrequency($userId);
        return count($data) > 0 ? $data[0]['label'] : '-';
    }

    // ── INSIGHT ─────────────────────────────────────────────
    private function insightEmosi($emosiDominan, $userId, $total)
    {
        if ($emosiDominan === '-' || $total === 0) {
            return 'Belum ada data emosi yang cukup untuk dianalisis.';
        }
        return "Kata <strong>\"{$emosiDominan}\"</strong> paling sering muncul dalam catatanmu. "
             . "Ini bisa jadi cerminan kondisi emosional yang dominan dan layak untuk kamu refleksikan lebih dalam.";
    }

    private function insightMindset($userId)
    {
        $rows = Refleksi::where('user_id', $userId)->pluck('mindset');
        if ($rows->isEmpty()) return 'Belum ada data pola pikir yang cukup.';

        // Deteksi kata kunci overthinking / positif / negatif
        $overthinking = 0; $positif = 0; $negatif = 0;
        $kwOverthinking = ['overthinking','terlalu','ragu','khawatir','takut','bingung','cemas'];
        $kwPositif      = ['tenang','percaya','optimis','bangga','bersyukur','senang','lega'];
        $kwNegatif      = ['pesimis','menyerah','gagal','sedih','kecewa','marah','stres'];

        foreach ($rows as $text) {
            $t = mb_strtolower($text);
            foreach ($kwOverthinking as $kw) { if (str_contains($t, $kw)) { $overthinking++; break; } }
            foreach ($kwPositif as $kw)      { if (str_contains($t, $kw)) { $positif++; break; } }
            foreach ($kwNegatif as $kw)      { if (str_contains($t, $kw)) { $negatif++; break; } }
        }

        $total = $rows->count();
        $pctPositif = $total > 0 ? round($positif / $total * 100) : 0;

        if ($overthinking > $positif && $overthinking > $negatif) {
            return "Pola pikirmu cenderung overthinking. Coba latih mindfulness untuk menenangkan pikiran sebelum mengambil keputusan.";
        }
        if ($positif >= $negatif) {
            return "Pola pikirmu didominasi oleh mindset positif ({$pctPositif}% dari refleksi). Pertahankan momentum ini!";
        }
        return "Ada kecenderungan pola pikir negatif dalam catatanmu. Ini bukan masalah — awareness adalah langkah pertama perubahan.";
    }

    private function insightKonsistensi($userId, $streak, $bulanIni)
    {
        if ($streak >= 7)  return "Luar biasa! Kamu sudah konsisten refleksi selama {$streak} hari berturut-turut. Konsistensi ini akan menghasilkan insight yang semakin akurat.";
        if ($streak >= 3)  return "Kamu sudah {$streak} hari berturut-turut refleksi. Pertahankan momentum ini!";
        if ($bulanIni > 0) return "Bulan ini kamu sudah refleksi {$bulanIni} kali. Coba tingkatkan konsistensi dengan refleksi setiap hari.";
        return "Belum ada refleksi bulan ini. Mulai hari ini dengan refleksi singkat untuk membangun kebiasaan positif!";
    }

    private function analisismendalam($userId, $total, $emosiDominan, $streak)
    {
        if ($total === 0) {
            return "Mulai perjalanan refleksi dirimu sekarang. Semakin banyak data yang kamu masukkan, semakin akurat analisis yang bisa sistem berikan.";
        }

        $parts = [];
        $parts[] = "Berdasarkan <strong>{$total} refleksi</strong> yang telah kamu catat, sistem mendeteksi pola dari tulisan bebasmu.";

        if ($emosiDominan !== '-') {
            $parts[] = "Emosi yang paling sering kamu ungkapkan adalah <strong>\"{$emosiDominan}\"</strong> — ini mencerminkan kondisi emosional yang paling dominan dalam keseharianmu.";
        }

        if ($streak >= 3) {
            $parts[] = "Dengan streak <strong>{$streak} hari</strong>, kamu menunjukkan konsistensi yang baik dalam membangun kesadaran diri.";
        }

        $parts[] = "Ingat: semakin rutin dan jujur kamu menulis, semakin tajam analisis yang bisa membantu perkembangan dirimu.";

        return implode(' ', $parts);
    }
}