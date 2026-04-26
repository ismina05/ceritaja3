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
        $user   = Auth::user();
        $userId = $user->id;

        // ===== STATS =====
        $totalRefleksi    = Refleksi::where('user_id', $userId)->count();
        $refleksiBulanIni = Refleksi::where('user_id', $userId)
                                ->whereMonth('tanggal', Carbon::now()->month)
                                ->whereYear('tanggal', Carbon::now()->year)
                                ->count();

        // Mood terbanyak → diganti: kata emosi yang paling sering muncul
        $emosiTerbanyak = null;
        $moodLabel      = '-';

        $refleksis = Refleksi::where('user_id', $userId)->pluck('emosi');
        if ($refleksis->count() > 0) {
            $wordCount = [];
            $positif   = ['senang','bangga','tenang','bersyukur','bahagia','lega','semangat'];
            $negatif   = ['sedih','cemas','stres','marah','takut','kecewa','lelah','capek'];
            $netral    = ['biasa','netral','hampa','datar'];

            foreach ($refleksis as $emosi) {
                $lower = strtolower($emosi);
                foreach (array_merge($positif, $negatif, $netral) as $kata) {
                    if (str_contains($lower, $kata)) {
                        $wordCount[$kata] = ($wordCount[$kata] ?? 0) + 1;
                    }
                }
            }

            if (!empty($wordCount)) {
                arsort($wordCount);
                $topKata = array_key_first($wordCount);
                $emoji   = in_array($topKata, $positif) ? '😊' : (in_array($topKata, $negatif) ? '😔' : '😐');
                $moodLabel = $emoji . ' ' . ucfirst($topKata);
            }
        }

        // ===== LINE CHART DATA =====
        // Harian (7 hari terakhir)
        $hariLabels = [];
        $hariData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date         = Carbon::now()->subDays($i);
            $hariLabels[] = $date->translatedFormat('D');
            $hariData[]   = Refleksi::where('user_id', $userId)
                                ->whereDate('tanggal', $date->toDateString())
                                ->count();
        }

        // Mingguan (4 minggu terakhir)
        $mingguLabels = [];
        $mingguData   = [];
        for ($i = 3; $i >= 0; $i--) {
            $start          = Carbon::now()->startOfWeek()->subWeeks($i);
            $end            = $start->copy()->endOfWeek();
            $mingguLabels[] = 'Mg ' . (4 - $i);
            $mingguData[]   = Refleksi::where('user_id', $userId)
                                ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
                                ->count();
        }

        // Bulanan (12 bulan)
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
            $year          = Carbon::now()->year - $i;
            $tahunLabels[] = (string) $year;
            $tahunData[]   = Refleksi::where('user_id', $userId)
                                ->whereYear('tanggal', $year)
                                ->count();
        }

        $lineChartData = [
            'hari'   => ['labels' => $hariLabels,  'data' => $hariData],
            'minggu' => ['labels' => $mingguLabels, 'data' => $mingguData],
            'bulan'  => ['labels' => $bulanLabels,  'data' => $bulanData],
            'tahun'  => ['labels' => $tahunLabels,  'data' => $tahunData],
        ];

        // ===== DONUT CHART (dari kata kunci tindakan) =====
        $kategoriTindakan = [
            ['label' => 'Belajar',    'kata' => ['belajar','studi','kuliah','tugas'], 'color' => '#a855f7'],
            ['label' => 'Produktif',  'kata' => ['selesai','kerja','produktif','menyelesaikan'], 'color' => '#60a5fa'],
            ['label' => 'Sosial',     'kata' => ['teman','keluarga','bicara','membantu'], 'color' => '#34d399'],
            ['label' => 'Istirahat',  'kata' => ['istirahat','tidur','santai','libur'], 'color' => '#fb923c'],
            ['label' => 'Olahraga',   'kata' => ['olahraga','lari','gym','jalan'], 'color' => '#f87171'],
        ];

        $tindakans      = Refleksi::where('user_id', $userId)->pluck('tindakan');
        $donutChartData = [];

        foreach ($kategoriTindakan as $kat) {
            $count = 0;
            foreach ($tindakans as $t) {
                $lower = strtolower($t);
                foreach ($kat['kata'] as $k) {
                    if (str_contains($lower, $k)) {
                        $count++;
                        break;
                    }
                }
            }
            $donutChartData[] = [
                'label' => $kat['label'],
                'value' => $count,
                'color' => $kat['color'],
            ];
        }

        // ===== INSIGHT =====
        $insight = $this->generateInsight($userId, $totalRefleksi, $moodLabel);

        return view('dashboard.index', compact(
            'totalRefleksi',
            'refleksiBulanIni',
            'moodLabel',
            'lineChartData',
            'donutChartData',
            'insight'
        ));
    }

    private function generateInsight($userId, $totalRefleksi, $moodLabel)
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

        if ($moodLabel !== '-') {
            $insight .= "Emosi yang paling sering muncul adalah {$moodLabel}. ";
        }

        if ($mingguIni > 0) {
            $insight .= "Minggu ini kamu sudah refleksi sebanyak {$mingguIni} kali — tetap semangat!";
        } else {
            $insight .= "Yuk mulai refleksi minggu ini untuk menjaga konsistensi perkembangan dirimu!";
        }

        return $insight;
    }
}