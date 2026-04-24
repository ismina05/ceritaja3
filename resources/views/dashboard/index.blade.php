<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CeritaJa</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-bg: #2d1b5e;
            --sidebar-width: 70px;
            --accent: #a855f7;
            --accent-light: #e9d5ff;
            --page-bg: #f3eeff;
            --card-bg: #ffffff;
            --text-primary: #1e1b4b;
            --text-muted: #7c6fa0;
            --border: rgba(168,85,247,0.12);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--page-bg);
            display: flex;
            min-height: 100vh;
            color: var(--text-primary);
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px 0;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
        }

        .sidebar-logo {
            width: 40px; height: 40px;
            background: var(--accent);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 40px;
            font-size: 18px; color: white;
        }

        .sidebar-nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
        }

        .nav-item {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.4);
            font-size: 20px;
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(168,85,247,0.25);
            color: white;
        }

        .nav-item.active {
            background: var(--accent);
            color: white;
        }

        .nav-item .tooltip {
            position: absolute;
            left: 56px;
            background: var(--sidebar-bg);
            color: white;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .nav-item:hover .tooltip { opacity: 1; }

        .sidebar-bottom {
            margin-top: auto;
        }

        .logout-btn {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.4);
            font-size: 20px;
            text-decoration: none;
            transition: all 0.2s;
            background: none; border: none; cursor: pointer;
        }

        .logout-btn:hover {
            background: rgba(239,68,68,0.2);
            color: #fca5a5;
        }

        /* ===== MAIN ===== */
        .main {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 32px 36px;
            max-width: calc(100vw - var(--sidebar-width));
        }

        /* ===== HEADER ===== */
        .header {
            margin-bottom: 28px;
        }

        .header h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .header p {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* ===== STATS ROW ===== */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 18px 20px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stat-icon {
            width: 42px; height: 42px;
            border-radius: 10px;
            background: var(--accent-light);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            color: var(--accent);
            flex-shrink: 0;
        }

        .stat-info .label {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 2px;
        }

        .stat-info .value {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* ===== CHARTS ROW ===== */
        .charts-row {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--border);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* ===== PERIOD FILTER ===== */
        .period-filter {
            display: flex;
            gap: 4px;
            background: var(--page-bg);
            padding: 4px;
            border-radius: 10px;
        }

        .period-btn {
            padding: 5px 12px;
            border-radius: 7px;
            border: none;
            background: transparent;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .period-btn.active {
            background: white;
            color: var(--accent);
            box-shadow: 0 1px 4px rgba(168,85,247,0.15);
        }

        /* ===== DONUT LEGEND ===== */
        .donut-legend {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .legend-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .legend-label { flex: 1; }
        .legend-val { font-weight: 600; color: var(--text-primary); }

        /* ===== INSIGHT BOX ===== */
        .insight-card {
            background: linear-gradient(135deg, #2d1b5e 0%, #4c1d95 100%);
            border-radius: 20px;
            padding: 24px;
            color: white;
        }

        .insight-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .insight-icon {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }

        .insight-title {
            font-size: 14px;
            font-weight: 600;
        }

        .insight-text {
            font-size: 13px;
            line-height: 1.7;
            color: rgba(255,255,255,0.8);
        }

        /* ===== CANVAS ===== */
        .chart-container {
            position: relative;
            height: 200px;
        }

        .donut-container {
            position: relative;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .empty-state i { font-size: 32px; margin-bottom: 8px; display: block; opacity: 0.4; }
    </style>
</head>
<body>

{{-- ===== SIDEBAR ===== --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <i class='bx bx-book-heart'></i>
    </div>

    <nav class="sidebar-nav">
        <a href="/dashboard" class="nav-item active">
            <i class='bx bxs-home'></i>
            <span class="tooltip">Dashboard</span>
        </a>
        <a href="/refleksi" class="nav-item">
            <i class='bx bx-book-open'></i>
            <span class="tooltip">Refleksi</span>
        </a>
        <a href="/riwayat" class="nav-item">
            <i class='bx bx-time-five'></i>
            <span class="tooltip">Riwayat</span>
        </a>
        <a href="/grafik" class="nav-item">
            <i class='bx bx-line-chart'></i>
            <span class="tooltip">Grafik</span>
        </a>
    </nav>

    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class='bx bx-log-out'></i>
            </button>
        </form>
    </div>
</aside>

{{-- ===== MAIN CONTENT ===== --}}
<main class="main">

    {{-- Header --}}
    <div class="header">
        <h1>Halo, {{ auth()->user()->name ?? 'User' }} 👋</h1>
        <p>Ringkasan perkembangan berdasarkan data refleksi</p>
    </div>

    {{-- Stats Row --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class='bx bx-note'></i></div>
            <div class="stat-info">
                <div class="label">Total Refleksi</div>
                <div class="value">{{ $totalRefleksi ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class='bx bx-calendar-check'></i></div>
            <div class="stat-info">
                <div class="label">Refleksi Bulan Ini</div>
                <div class="value">{{ $refleksiBulanIni ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class='bx bx-trending-up'></i></div>
            <div class="stat-info">
                <div class="label">Mood Terbanyak</div>
                <div class="value">{{ $moodLabel ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="charts-row">

        {{-- Line Chart --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Perkembangan Refleksi</span>
                <div class="period-filter">
                    <button class="period-btn active" onclick="switchPeriod(this, 'hari')">Hari</button>
                    <button class="period-btn" onclick="switchPeriod(this, 'minggu')">Minggu</button>
                    <button class="period-btn" onclick="switchPeriod(this, 'bulan')">Bulan</button>
                    <button class="period-btn" onclick="switchPeriod(this, 'tahun')">Tahun</button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        {{-- Donut Chart --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Aspek Refleksi</span>
            </div>
            <div class="donut-container">
                <canvas id="donutChart"></canvas>
            </div>
            <div class="donut-legend" id="donutLegend"></div>
        </div>

    </div>

    {{-- Insight --}}
    <div class="insight-card">
        <div class="insight-header">
            <div class="insight-icon">✨</div>
            <div class="insight-title">Insight Otomatis</div>
        </div>
        <p class="insight-text">
            {{ $insight ?? 'Mulai catat refleksi harianmu untuk mendapatkan insight perkembangan diri yang personal dan bermakna.' }}
        </p>
    </div>

</main>

<script>
    @php
    $defaultLineData = [
        'hari' => [
            'labels' => ['Sen','Sel','Rab','Kam','Jum','Sab','Min'],
            'data' => [0,0,0,0,0,0,0]
        ],
        'minggu' => [
            'labels' => ['Mg 1','Mg 2','Mg 3','Mg 4'],
            'data' => [0,0,0,0]
        ],
        'bulan' => [
            'labels' => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
            'data' => [0,0,0,0,0,0,0,0,0,0,0,0]
        ],
        'tahun' => [
            'labels' => ['2026','2027','2028','2029'],
            'data' => [0,0,0,0]
        ]
    ];

    $defaultDonutData = [
        ['label' => 'Mental',   'value' => 0, 'color' => '#a855f7'],
        ['label' => 'Akademik', 'value' => 0, 'color' => '#60a5fa'],
        ['label' => 'Karir',    'value' => 0, 'color' => '#34d399'],
        ['label' => 'Sosial',   'value' => 0, 'color' => '#fb923c'],
        ['label' => 'Fisik',    'value' => 0, 'color' => '#f87171'],
    ];
    @endphp

    const lineData = @json($lineChartData ?? $defaultLineData);
    const donutData = @json($donutChartData ?? $defaultDonutData);

    // ===== LINE CHART =====
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    const gradient = lineCtx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(168,85,247,0.3)');
    gradient.addColorStop(1, 'rgba(168,85,247,0)');

    let lineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: lineData.hari.labels,
            datasets: [{
                data: lineData.hari.data,
                borderColor: '#a855f7',
                backgroundColor: gradient,
                borderWidth: 2.5,
                fill: true,
                tension: 0.45,
                pointBackgroundColor: '#a855f7',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });

    function switchPeriod(btn, period) {
        document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        lineChart.data.labels = lineData[period].labels;
        lineChart.data.datasets[0].data = lineData[period].data;
        lineChart.update();
    }

    // ===== DONUT =====
    const donutCtx = document.getElementById('donutChart').getContext('2d');
    const hasData = donutData.some(d => d.value > 0);

    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: donutData.map(d => d.label),
            datasets: [{
                data: hasData ? donutData.map(d => d.value) : [1],
                backgroundColor: hasData ? donutData.map(d => d.color) : ['#e9d5ff'],
                borderWidth: 0
            }]
        }
    });

    // legend
    const legend = document.getElementById('donutLegend');
    donutData.forEach(d => {
        legend.innerHTML += `
        <div class="legend-item">
            <div class="legend-dot" style="background:${d.color}"></div>
            <span class="legend-label">${d.label}</span>
            <span class="legend-val">${d.value}</span>
        </div>`;
    });
</script>

</body>
</html>