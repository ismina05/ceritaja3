<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — CeritaJa</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { overflow-x: hidden; width: 100%; }

        :root {
            --sidebar-bg: #2d1b5e;
            --sidebar-w: 66px;
            --ink: #1e1b4b;
            --ink-muted: #7c6fa0;
            --ink-faint: #c5bcd8;
            --page: #f3eeff;
            --card: #ffffff;
            --accent: #7b52d4;
            --accent-soft: #f3e8ff;
            --warm: #e9d5ff;
            --border: rgba(123,82,212,0.1);
            --radius: 18px;
            --shadow: 0 2px 8px rgba(28,21,40,0.05), 0 6px 24px rgba(28,21,40,0.05);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--page);
            display: flex;
            min-height: 100vh;
            color: var(--ink);
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex; flex-direction: column; align-items: center;
            padding: 20px 0 22px;
            position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
        }
        .sidebar-logo {
            width: 36px; height: 36px; background: var(--accent);
            border-radius: 11px; display: flex; align-items: center; justify-content: center;
            font-size: 17px; color: white; margin-bottom: 34px;
            box-shadow: 0 4px 12px rgba(123,82,212,0.45);
        }
        .sidebar-nav { flex: 1; display: flex; flex-direction: column; gap: 4px; align-items: center; }
        .nav-item {
            width: 40px; height: 40px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.28); font-size: 19px;
            text-decoration: none; transition: all 0.16s; position: relative;
        }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.7); }
        .nav-item.active { background: var(--accent); color: white; box-shadow: 0 3px 10px rgba(123,82,212,0.4); }
        .nav-item .tip {
            position: absolute; left: 52px;
            background: var(--ink); color: white;
            font-size: 11.5px; font-weight: 500;
            padding: 4px 10px; border-radius: 7px;
            white-space: nowrap; opacity: 0; pointer-events: none;
            transition: opacity 0.14s; z-index: 200;
        }
        .nav-item:hover .tip { opacity: 1; }
        .sidebar-bottom { margin-top: auto; }
        .logout-btn {
            width: 40px; height: 40px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.28); font-size: 19px;
            background: none; border: none; cursor: pointer; transition: all 0.16s;
        }
        .logout-btn:hover { background: rgba(239,68,68,0.15); color: #fca5a5; }

        /* ── MAIN ── */
        .main { margin-left: var(--sidebar-w); flex: 1; width: calc(100% - var(--sidebar-w)); }

        /* ── HERO ── */
        .hero {
            background: var(--sidebar-bg);
            padding: 40px 48px 36px;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; top: -60px; right: -40px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(123,82,212,0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-inner { position: relative; z-index: 1; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 20px; }
        .hero-left {}
        .hero-greeting {
            font-size: 12px; color: rgba(255,255,255,0.35);
            letter-spacing: 0.5px; margin-bottom: 8px;
        }
        .hero-name {
            font-size: 28px; font-weight: 700; color: white;
            letter-spacing: -0.4px; margin-bottom: 6px;
        }
        .hero-name span { color: #c4a8f8; }
        .hero-sub { font-size: 13.5px; color: rgba(255,255,255,0.4); font-weight: 300; }
        .hero-cta {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--accent); color: white;
            padding: 11px 20px; border-radius: 12px;
            font-size: 13.5px; font-weight: 600;
            text-decoration: none; transition: all 0.18s;
            box-shadow: 0 4px 14px rgba(123,82,212,0.4);
            white-space: nowrap;
        }
        .hero-cta:hover { background: #6b40c8; transform: translateY(-1px); }

        /* ── CONTENT ── */
        .content { padding: 32px 48px 48px; display: flex; flex-direction: column; gap: 24px; }

        /* ── STATS ROW ── */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .stat-card {
            background: var(--card); border-radius: var(--radius);
            border: 1px solid var(--border); box-shadow: var(--shadow);
            padding: 20px 22px;
            display: flex; align-items: center; gap: 16px;
        }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .stat-icon.purple { background: #ede8fb; color: #7b52d4; }
        .stat-icon.amber  { background: #fef3c7; color: #d97706; }
        .stat-icon.green  { background: #dcfce7; color: #16a34a; }
        .stat-info {}
        .stat-val { font-size: 26px; font-weight: 700; color: var(--ink); line-height: 1; margin-bottom: 4px; }
        .stat-lbl { font-size: 12px; color: var(--ink-muted); font-weight: 500; }

        /* ── GRID ── */
        .main-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start; }
        .left-col  { display: flex; flex-direction: column; gap: 20px; }
        .right-col { display: flex; flex-direction: column; gap: 20px; }

        /* ── CARD ── */
        .card {
            background: var(--card); border-radius: var(--radius);
            border: 1px solid var(--border); box-shadow: var(--shadow);
            padding: 22px 24px;
        }
        .card-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 18px;
        }
        .card-title {
            font-size: 14px; font-weight: 600; color: var(--ink);
            display: flex; align-items: center; gap: 8px;
        }
        .card-title i { color: var(--accent); font-size: 18px; }

        /* ── TREN TABS ── */
        .tren-tabs { display: flex; gap: 6px; }
        .tren-tab {
            padding: 5px 12px; border-radius: 20px;
            font-size: 12px; font-weight: 500;
            color: var(--ink-muted); background: var(--page);
            border: 1.5px solid var(--border);
            cursor: pointer; transition: all 0.15s;
        }
        .tren-tab.active { background: var(--accent); color: white; border-color: var(--accent); }
        .chart-wrap { position: relative; height: 200px; }

        /* ── DONUT ── */
        .donut-wrap { display: flex; align-items: center; gap: 24px; }
        .donut-canvas { flex-shrink: 0; }
        .donut-legend { flex: 1; display: flex; flex-direction: column; gap: 8px; }
        .legend-item { display: flex; align-items: center; gap: 8px; font-size: 12.5px; color: var(--ink); }
        .legend-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }
        .legend-val { margin-left: auto; font-weight: 600; font-size: 12px; color: var(--ink-muted); }

        /* ── INSIGHT ── */
        .insight-box {
            background: linear-gradient(135deg, #18122b, #2d1f52);
            border-radius: var(--radius); padding: 20px 22px;
        }
        .insight-label {
            font-size: 10.5px; font-weight: 600; color: rgba(255,255,255,0.35);
            text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 10px;
            display: flex; align-items: center; gap: 6px;
        }
        .insight-label i { color: #c4a8f8; font-size: 14px; }
        .insight-text { font-size: 13px; color: rgba(255,255,255,0.65); line-height: 1.65; }

        /* ── QUICK ACTIONS ── */
        .quick-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .quick-btn {
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            padding: 16px 12px; border-radius: 14px;
            background: var(--page); border: 1.5px solid var(--border);
            text-decoration: none; color: var(--ink-muted);
            font-size: 12px; font-weight: 500;
            transition: all 0.16s; text-align: center;
        }
        .quick-btn i { font-size: 22px; color: var(--accent); }
        .quick-btn:hover { background: var(--accent-soft); border-color: var(--accent); color: var(--accent); }
        .quick-btn.primary {
            background: var(--accent); color: white; border-color: var(--accent);
            grid-column: span 2;
            flex-direction: row; justify-content: center; padding: 14px;
            font-size: 13.5px; font-weight: 600;
            box-shadow: 0 4px 14px rgba(123,82,212,0.35);
        }
        .quick-btn.primary i { color: white; font-size: 18px; }
        .quick-btn.primary:hover { background: #6b40c8; transform: translateY(-1px); }

        /* ── MOOD BADGE ── */
        .mood-badge {
            background: var(--accent-soft); border: 1.5px solid var(--border);
            border-radius: 14px; padding: 16px 18px;
            display: flex; align-items: center; gap: 14px;
        }
        .mood-emoji { font-size: 32px; }
        .mood-info {}
        .mood-label-text { font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 2px; }
        .mood-sub { font-size: 11.5px; color: var(--ink-muted); }

        /* ── SUCCESS ALERT ── */
        .alert-success {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-radius: 12px; padding: 11px 16px;
            font-size: 13px; color: #16a34a;
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo"><i class='bx bx-book-heart'></i></div>
    <nav class="sidebar-nav">
        <a href="/dashboard" class="nav-item active"><i class='bx bxs-home'></i><span class="tip">Dashboard</span></a>
        <a href="/refleksi" class="nav-item"><i class='bx bx-book-open'></i><span class="tip">Refleksi</span></a>
        <a href="/riwayat" class="nav-item"><i class='bx bx-time-five'></i><span class="tip">Riwayat</span></a>
        <a href="/grafik" class="nav-item"><i class='bx bx-line-chart'></i><span class="tip">Grafik</span></a>
    </nav>
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="logout-btn" title="Keluar"><i class='bx bx-log-out'></i></button>
        </form>
    </div>
</aside>

<main class="main">

    <!-- HERO -->
    <div class="hero">
        <div class="hero-inner">
            <div class="hero-left">
                <div class="hero-greeting">{{ now()->translatedFormat('l, d F Y') }}</div>
                <div class="hero-name">Halo, <span>{{ Auth::user()->name }}</span> 👋</div>
                <div class="hero-sub">Bagaimana harimu? Yuk catat refleksimu sekarang.</div>
            </div>
            <a href="/refleksi" class="hero-cta"><i class='bx bx-plus'></i> Refleksi Baru</a>
        </div>
    </div>

    <div class="content">

        @if(session('success'))
            <div class="alert-success"><i class='bx bx-check-circle'></i> {{ session('success') }}</div>
        @endif

        <!-- STATS -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon purple"><i class='bx bx-book-open'></i></div>
                <div class="stat-info">
                    <div class="stat-val">{{ $totalRefleksi }}</div>
                    <div class="stat-lbl">Total Refleksi</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon amber"><i class='bx bx-calendar-check'></i></div>
                <div class="stat-info">
                    <div class="stat-val">{{ $refleksiBulanIni }}</div>
                    <div class="stat-lbl">Bulan Ini</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class='bx bx-trending-up'></i></div>
                <div class="stat-info">
                    <div class="stat-val">{{ $moodLabel }}</div>
                    <div class="stat-lbl">Emosi Dominan</div>
                </div>
            </div>
        </div>

        <!-- MAIN GRID -->
        <div class="main-grid">

            <!-- KIRI -->
            <div class="left-col">

                <!-- TREN CHART -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><i class='bx bx-line-chart'></i> Tren Refleksi</div>
                        <div class="tren-tabs">
                            <button class="tren-tab active" onclick="switchTren('hari', this)">Harian</button>
                            <button class="tren-tab" onclick="switchTren('minggu', this)">Mingguan</button>
                            <button class="tren-tab" onclick="switchTren('bulan', this)">Bulanan</button>
                            <button class="tren-tab" onclick="switchTren('tahun', this)">Tahunan</button>
                        </div>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="trenChart"></canvas>
                    </div>
                </div>

                <!-- DONUT TINDAKAN -->
                <!--
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><i class='bx bx-pie-chart-alt-2'></i> Distribusi Tindakan</div>
                    </div>
                    <div class="donut-wrap">
                        <canvas id="donutChart" class="donut-canvas" width="140" height="140"></canvas>
                        <div class="donut-legend" id="donutLegend"></div>
                    </div>
                </div> -->
                

            </div>

            <!-- KANAN -->
            <div class="right-col">

                <!-- QUICK ACTIONS -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><i class='bx bx-zap'></i> Aksi Cepat</div>
                    </div>
                    <div class="quick-grid">
                        <a href="/refleksi" class="quick-btn primary"><i class='bx bx-plus-circle'></i> Tambah Refleksi</a>
                        <a href="/riwayat" class="quick-btn"><i class='bx bx-time-five'></i> Riwayat</a>
                        <a href="/grafik" class="quick-btn"><i class='bx bx-bar-chart-alt-2'></i> Grafik</a>
                    </div>
                </div>

                <!-- INSIGHT -->
                <div class="insight-box">
                    <div class="insight-label"><i class='bx bx-bulb'></i> Insight Harianmu</div>
                    <div class="insight-text">{{ $insight }}</div>
                </div>

            </div>
        </div>
    </div>
</main>

<script>
const lineData = @json($lineChartData);
// const donutData = @json($donutChartData); 

// ── TREN CHART ──
const trenCtx = document.getElementById('trenChart').getContext('2d');
let trenChart = new Chart(trenCtx, {
    type: 'line',
    data: {
        labels: lineData.hari.labels,
        datasets: [{
            label: 'Refleksi',
            data: lineData.hari.data,
            borderColor: '#7b52d4',
            backgroundColor: 'rgba(123,82,212,0.08)',
            borderWidth: 2.5,
            pointBackgroundColor: '#7b52d4',
            pointRadius: 4,
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#8a7fa0' } },
            y: { grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { stepSize: 1, font: { size: 11 }, color: '#8a7fa0' }, beginAtZero: true }
        }
    }
});

function switchTren(period, btn) {
    document.querySelectorAll('.tren-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    trenChart.data.labels = lineData[period].labels;
    trenChart.data.datasets[0].data = lineData[period].data;
    trenChart.update();
}

/*
// ── DONUT CHART ──
const donutCtx = document.getElementById('donutChart').getContext('2d');
const donutFiltered = donutData.filter(d => d.value > 0);
const hasDonut = donutFiltered.length > 0;

new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        labels: hasDonut ? donutFiltered.map(d => d.label) : ['Belum ada data'],
        datasets: [{
            data: hasDonut ? donutFiltered.map(d => d.value) : [1],
            backgroundColor: hasDonut ? donutFiltered.map(d => d.color) : ['#e8dcc8'],
            borderWidth: 0,
            hoverOffset: 4,
        }]
    },
    options: {
        responsive: false,
        cutout: '70%',
        plugins: { legend: { display: false }, tooltip: { enabled: hasDonut } }
    }
});

// Legend
const legendEl = document.getElementById('donutLegend');
const legendSource = hasDonut ? donutFiltered : donutData;
legendSource.forEach(d => {
    legendEl.innerHTML += `
        <div class="legend-item">
            <div class="legend-dot" style="background:${d.color}"></div>
            <span>${d.label}</span>
            <span class="legend-val">${d.value}x</span>
        </div>`;
});
*/
</script>

</body>
</html>