<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Refleksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // ===== STATS =====
        $totalRefleksi     = Refleksi::where('user_id', $userId)->count();
        $refleksiBulanIni  = Refleksi::where('user_id', $userId)
                                ->whereMonth('tanggal', Carbon::now()->month)
                                ->whereYear('tanggal', Carbon::now()->year)
                                ->count();

        $moodTerbanyak = Refleksi::where('user_id', $userId)
                            ->join('moods', 'refleksis.mood_id', '=', 'moods.id')
                            ->selectRaw('moods.nama_mood, moods.emoji, count(*) as total')
                            ->groupBy('moods.nama_mood', 'moods.emoji')
                            ->orderByDesc('total')
                            ->first();

        $moodLabel = $moodTerbanyak
            ? $moodTerbanyak->emoji . ' ' . $moodTerbanyak->nama_mood
            : '-';

        // ===== LINE CHART DATA =====
        // Harian (7 hari terakhir)
        $hariLabels = [];
        $hariData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $hariLabels[] = $date->translatedFormat('D');
            $hariData[]   = Refleksi::where('user_id', $userId)
                                ->whereDate('tanggal', $date->toDateString())
                                ->count();
        }

        // Mingguan (4 minggu terakhir)
        $mingguLabels = [];
        $mingguData   = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = Carbon::now()->startOfWeek()->subWeeks($i);
            $end   = $start->copy()->endOfWeek();
            $mingguLabels[] = 'Mg ' . (4 - $i);
            $mingguData[]   = Refleksi::where('user_id', $userId)
                                ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
                                ->count();
        }

        // Bulanan (12 bulan terakhir)
        $bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
        $bulanData   = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanData[] = Refleksi::where('user_id', $userId)
                            ->whereMonth('tanggal', $i)
                            ->whereYear('tanggal', Carbon::now()->year)
                            ->count();
        }

        // Tahunan (4 tahun terakhir)
        $tahunLabels = [];
        $tahunData   = [];
        for ($i = 3; $i >= 0; $i--) {
            $year = Carbon::now()->year - $i;
            $tahunLabels[] = (string) $year;
            $tahunData[]   = Refleksi::where('user_id', $userId)
                                ->whereYear('tanggal', $year)
                                ->count();
        }

        $lineChartData = [
            'hari'   => ['labels' => $hariLabels,   'data' => $hariData],
            'minggu' => ['labels' => $mingguLabels,  'data' => $mingguData],
            'bulan'  => ['labels' => $bulanLabels,   'data' => $bulanData],
            'tahun'  => ['labels' => $tahunLabels,   'data' => $tahunData],
        ];

        // ===== DONUT CHART (Aspek) =====
        $aspeks = \App\Models\Aspek::all();
        $donutChartData = $aspeks->map(function ($aspek) use ($userId) {
            return [
                'label' => $aspek->nama_aspek,
                'value' => Refleksi::where('user_id', $userId)
                            ->where('aspek_id', $aspek->id)
                            ->count(),
                'color' => $aspek->warna ?? '#a855f7',
            ];
        })->values()->toArray();

        // ===== INSIGHT =====
        $insight = $this->generateInsight($userId, $totalRefleksi, $moodTerbanyak);

        return view('dashboard.index', compact(
            'totalRefleksi',
            'refleksiBulanIni',
            'moodLabel',
            'lineChartData',
            'donutChartData',
            'insight'
        ));
    }

    private function generateInsight($userId, $totalRefleksi, $moodTerbanyak)
    {
        if ($totalRefleksi === 0) {
            return 'Mulai catat refleksi harianmu untuk mendapatkan insight perkembangan diri yang personal dan bermakna.';
        }

        $mingguIni = Refleksi::where('user_id', $userId)
                        ->whereBetween('tanggal', [
                            Carbon::now()->startOfWeek()->toDateString(),
                            Carbon::now()->toDateString()
                        ])->count();

        $insight = "Kamu sudah mencatat {$totalRefleksi} refleksi. ";

        if ($moodTerbanyak) {
            $insight .= "Mood yang paling sering muncul adalah {$moodTerbanyak->emoji} {$moodTerbanyak->nama_mood}. ";
        }

        if ($mingguIni > 0) {
            $insight .= "Minggu ini kamu sudah refleksi sebanyak {$mingguIni} kali — tetap semangat!";
        } else {
            $insight .= "Yuk mulai refleksi minggu ini untuk menjaga konsistensi perkembangan dirimu!";
        }

        return $insight;
    }
}
