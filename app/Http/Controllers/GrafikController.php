<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Refleksi;
use App\Models\Mood;
use App\Models\Aspek;
use App\Models\Kategori;
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

        // Streak — hitung hari berturut-turut
        $streak = $this->hitungStreak($userId);

        // Mood dominan
        $moodTop = Refleksi::where('user_id', $userId)
                    ->join('moods', 'refleksis.mood_id', '=', 'moods.id')
                    ->selectRaw('moods.nama_mood, moods.emoji, count(*) as total')
                    ->groupBy('moods.nama_mood', 'moods.emoji')
                    ->orderByDesc('total')
                    ->first();

        $moodDominan = $moodTop ? $moodTop->emoji . ' ' . $moodTop->nama_mood : '-';

        // Aspek dominan
        $aspekTop = Refleksi::where('user_id', $userId)
                    ->join('aspeks', 'refleksis.aspek_id', '=', 'aspeks.id')
                    ->selectRaw('aspeks.nama_aspek, count(*) as total')
                    ->groupBy('aspeks.nama_aspek')
                    ->orderByDesc('total')
                    ->first();

        $aspekDominan = $aspekTop ? $aspekTop->nama_aspek : '-';

        // ===== TREN CHART =====
        $tren = [
            'minggu' => $this->trenMinggu($userId),
            'bulan'  => $this->trenBulan($userId),
            'tahun'  => $this->trenTahun($userId),
        ];

        // ===== ASPEK DATA =====
        $aspekData = Aspek::all()->map(function ($a) use ($userId) {
            return [
                'label' => $a->nama_aspek,
                'value' => Refleksi::where('user_id', $userId)->where('aspek_id', $a->id)->count(),
                'color' => $a->warna ?? '#a855f7',
            ];
        })->values()->toArray();

        // ===== MOOD DATA =====
        $moodData = Mood::all()->map(function ($m) use ($userId) {
            return [
                'label' => $m->nama_mood,
                'emoji' => $m->emoji,
                'value' => Refleksi::where('user_id', $userId)->where('mood_id', $m->id)->count(),
                'color' => $m->warna ?? '#a855f7',
            ];
        })->sortByDesc('value')->values()->toArray();

        // ===== KATEGORI DATA =====
        $katData = Kategori::all()->map(function ($k) use ($userId) {
            return [
                'label' => $k->nama_kategori,
                'value' => Refleksi::where('user_id', $userId)->where('kategori_id', $k->id)->count(),
            ];
        })->sortByDesc('value')->values()->toArray();

        $chartData = [
            'tren'     => $tren,
            'aspek'    => $aspekData,
            'mood'     => $moodData,
            'kategori' => $katData,
        ];

        // ===== INSIGHT =====
        $pola_emosi       = $this->insightEmosi($moodTop, $userId);
        $pola_aspek       = $this->insightAspek($aspekTop, $userId);
        $pola_konsistensi = $this->insightKonsistensi($userId, $streak, $bulanIni);
        $analisis_mendalam = $this->analisismendalam($userId, $totalRefleksi, $moodTop, $aspekTop, $streak);

        return view('grafik.index', compact(
            'totalRefleksi', 'bulanIni', 'streak', 'moodDominan', 'aspekDominan',
            'chartData', 'pola_emosi', 'pola_aspek', 'pola_konsistensi', 'analisis_mendalam'
        ));
    }

    private function hitungStreak($userId)
    {
        $streak = 0;
        $date = Carbon::today();

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

    private function trenMinggu($userId)
    {
        $labels = [];
        $data   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->translatedFormat('D');
            $data[]   = Refleksi::where('user_id', $userId)
                            ->whereDate('tanggal', $date->toDateString())
                            ->count();
        }
        return ['labels' => $labels, 'data' => $data];
    }

    private function trenBulan($userId)
    {
        $labels = [];
        $data   = [];
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

    private function insightEmosi($moodTop, $userId)
    {
        if (!$moodTop) return 'Belum ada data mood yang cukup untuk dianalisis.';
        $total = Refleksi::where('user_id', $userId)->count();
        $pct   = $total > 0 ? round(($moodTop->total / $total) * 100) : 0;
        return "Ini muncul pada {$pct}% dari total refleksimu. Pola ini bisa jadi cerminan kondisi emosional yang perlu kamu perhatikan.";
    }

    private function insightAspek($aspekTop, $userId)
    {
        if (!$aspekTop) return 'Belum ada data aspek yang cukup.';
        $aspekJarang = Refleksi::where('user_id', $userId)
                        ->join('aspeks', 'refleksis.aspek_id', '=', 'aspeks.id')
                        ->selectRaw('aspeks.nama_aspek, count(*) as total')
                        ->groupBy('aspeks.nama_aspek')
                        ->orderBy('total')
                        ->first();

        $result = "Ini menunjukkan kamu banyak fokus ke area ini.";
        if ($aspekJarang && $aspekJarang->nama_aspek !== $aspekTop->nama_aspek) {
            $result .= " Sementara aspek {$aspekJarang->nama_aspek} masih jarang direfleksikan — mungkin perlu lebih diperhatikan.";
        }
        return $result;
    }

    private function insightKonsistensi($userId, $streak, $bulanIni)
    {
        if ($streak >= 7) return "Luar biasa! Kamu sudah konsisten refleksi selama {$streak} hari berturut-turut. Konsistensi ini akan menghasilkan insight yang semakin akurat.";
        if ($streak >= 3) return "Kamu sudah {$streak} hari berturut-turut refleksi. Pertahankan momentum ini!";
        if ($bulanIni > 0) return "Bulan ini kamu sudah refleksi {$bulanIni} kali. Coba tingkatkan konsistensi dengan refleksi setiap hari untuk hasil yang lebih baik.";
        return "Belum ada refleksi bulan ini. Mulai hari ini dengan refleksi singkat untuk membangun kebiasaan positif!";
    }

    private function analisismendalam($userId, $total, $moodTop, $aspekTop, $streak)
    {
        if ($total === 0) {
            return "Mulai perjalanan refleksi dirimu sekarang. Semakin banyak data yang kamu masukkan, semakin akurat analisis yang bisa sistem berikan untuk membantumu memahami pola diri secara objektif.";
        }

        $parts = [];

        if ($moodTop) {
            $parts[] = "Berdasarkan {$total} refleksi yang telah kamu catat, mood <strong>{$moodTop->emoji} {$moodTop->nama_mood}</strong> mendominasi pengalamanmu.";
        }

        if ($aspekTop) {
            $parts[] = "Aspek <strong>{$aspekTop->nama_aspek}</strong> menjadi fokus utama refleksimu, menunjukkan area kehidupan yang paling banyak kamu pikirkan dan evaluasi.";
        }

        if ($streak >= 3) {
            $parts[] = "Dengan streak <strong>{$streak} hari</strong>, kamu menunjukkan konsistensi yang baik dalam membangun kesadaran diri.";
        }

        $parts[] = "Ingat: kualitas insight sistem sangat bergantung pada konsistensi inputmu. Semakin rutin kamu refleksi, semakin tajam analisis yang bisa membantu keputusan pengembangan dirimu.";

        return implode(' ', $parts);
    }
}
