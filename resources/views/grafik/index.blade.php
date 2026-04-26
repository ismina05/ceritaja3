<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik - CeritaJa</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { overflow-x: hidden; width: 100%; }

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

        .nav-item:hover { background: rgba(168,85,247,0.25); color: white; }
        .nav-item.active { background: var(--accent); color: white; }

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
        .sidebar-bottom { margin-top: auto; }

        .logout-btn {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.4);
            font-size: 20px;
            background: none; border: none; cursor: pointer;
            transition: all 0.2s;
        }

        .logout-btn:hover { background: rgba(239,68,68,0.2); color: #fca5a5; }

        /* ===== MAIN ===== */
        .main {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 32px 36px;
            width: calc(100% - var(--sidebar-width));
        }

        /* ===== HEADER ===== */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-header h1 { font-size: 22px; font-weight: 700; }
        .page-header p { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

        /* ===== PERIOD FILTER ===== */
        .period-filter {
            display: flex;
            gap: 4px;
            background: white;
            padding: 4px;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .period-btn {
            padding: 7px 18px;
            border-radius: 9px;
            border: none;
            background: transparent;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .period-btn.active {
            background: var(--accent);
            color: white;
            box-shadow: 0 2px 8px rgba(168,85,247,0.3);
        }

        /* ===== STATS ROW ===== */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 16px 18px;
            border: 1px solid var(--border);
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .stat-sub {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .stat-trend {
            font-size: 11px;
            font-weight: 600;
            margin-top: 4px;
        }

        .trend-up { color: #22c55e; }
        .trend-down { color: #ef4444; }

        /* ===== GRID ===== */
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .charts-grid-3 {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 22px;
            border: 1px solid var(--border);
        }

        .card-full {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 22px;
            border: 1px solid var(--border);
            margin-bottom: 16px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .chart-container { position: relative; height: 200px; }
        .chart-sm { position: relative; height: 160px; }
        .chart-lg { position: relative; height: 240px; }

        /* ===== MOOD BAR ===== */
        .mood-bars {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mood-bar-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mood-bar-label {
            font-size: 12px;
            color: var(--text-muted);
            width: 70px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .mood-bar-track {
            flex: 1;
            height: 8px;
            background: var(--page-bg);
            border-radius: 4px;
            overflow: hidden;
        }

        .mood-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.8s ease;
        }

        .mood-bar-count {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-primary);
            width: 24px;
            text-align: right;
        }

        /* ===== INSIGHT CARDS ===== */
        .insight-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 16px;
        }

        .insight-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 18px;
            border: 1px solid var(--border);
        }

        .insight-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .insight-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .insight-icon.purple { background: #f3e8ff; }
        .insight-icon.blue { background: #eff6ff; }
        .insight-icon.green { background: #f0fdf4; }

        .insight-card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .insight-card-desc {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .insight-highlight {
            font-weight: 600;
            color: var(--accent);
        }

        /* ===== ANALISIS BOX ===== */
        .analisis-box {
            background: linear-gradient(135deg, #2d1b5e 0%, #4c1d95 100%);
            border-radius: 20px;
            padding: 24px;
            color: white;
        }

        .analisis-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .analisis-icon {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }

        .analisis-title { font-size: 15px; font-weight: 600; }

        .analisis-text {
            font-size: 13px;
            line-height: 1.8;
            color: rgba(255,255,255,0.85);
        }

        .analisis-text strong { color: #e9d5ff; }

        /* ===== LEGEND ===== */
        .legend-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 14px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .legend-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
        }
    </style>
</head>
<body>

{{-- ===== SIDEBAR ===== --}}
<aside class="sidebar">
    <div class="sidebar-logo"><i class='bx bx-book-heart'></i></div>
    <nav class="sidebar-nav">
        <a href="/dashboard" class="nav-item">
            <i class='bx bxs-home'></i><span class="tooltip">Dashboard</span>
        </a>
        <a href="/refleksi" class="nav-item">
            <i class='bx bx-book-open'></i><span class="tooltip">Refleksi</span>
        </a>
        <a href="/riwayat" class="nav-item">
            <i class='bx bx-time-five'></i><span class="tooltip">Riwayat</span>
        </a>
        <a href="/grafik" class="nav-item active">
            <i class='bx bx-line-chart'></i><span class="tooltip">Grafik</span>
        </a>
    </nav>
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn"><i class='bx bx-log-out'></i></button>
        </form>
    </div>
</aside>

{{-- ===== MAIN ===== --}}
<main class="main">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1>Analisis Grafik</h1>
            <p>Eksplorasi pola dan perkembangan refleksimu secara mendalam</p>
        </div>
        <div class="period-filter">
            <button class="period-btn active" onclick="setPeriod(this, 'minggu')">Minggu</button>
            <button class="period-btn" onclick="setPeriod(this, 'bulan')">Bulan</button>
            <button class="period-btn" onclick="setPeriod(this, 'tahun')">Tahun</button>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label"><i class='bx bx-note' style="color:var(--accent)"></i> Total Refleksi</div>
            <div class="stat-value">{{ $totalRefleksi }}</div>
            <div class="stat-sub">Sepanjang waktu</div>
        </div>
        <div class="stat-card">
            <div class="stat-label"><i class='bx bx-calendar' style="color:#60a5fa"></i> Bulan Ini</div>
            <div class="stat-value">{{ $bulanIni }}</div>
            <div class="stat-sub">{{ now()->translatedFormat('F Y') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label"><i class='bx bx-trending-up' style="color:#34d399"></i> Streak</div>
            <div class="stat-value">{{ $streak }} hari</div>
            <div class="stat-sub">Konsistensi refleksi</div>
        </div>
        <div class="stat-card">
            <div class="stat-label"><i class='bx bx-happy' style="color:#fb923c"></i> Emosi Dominan</div>
            <div class="stat-value" style="font-size:18px">{{ $emosiDominan }}</div>
            <div class="stat-sub">Paling sering muncul</div>
        </div>
    </div>

    {{-- Chart Tren + Donut Aspek --}}
    <div class="charts-grid">
        {{-- Tren Refleksi --}}
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Tren Refleksi</div>
                    <div class="card-subtitle">Frekuensi refleksi dari waktu ke waktu</div>
                </div>
            </div>
            <div class="chart-lg">
                <canvas id="trenChart"></canvas>
            </div>
        </div>

        {{-- Distribusi Emosi Donut --}}
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Top Kata Emosi</div>
                    <div class="card-subtitle">Proporsi kata emosi dominan</div>
                </div>
            </div>
            <div class="chart-sm">
                <canvas id="emosiChart"></canvas>
            </div>
            <div class="legend-row" id="emosiLegend"></div>
        </div>
    </div>

    {{-- Distribusi Emosi (word frequency) --}}
    <div class="card-full">
        <div class="card-header">
            <div>
                <div class="card-title">Distribusi Kata Emosi</div>
                <div class="card-subtitle">Kata yang paling sering muncul dalam catatanmu</div>
            </div>
        </div>
        <div class="mood-bars" id="emosiBars"></div>
    </div>

    {{-- Insight Cards --}}
    <div class="insight-grid">
        <div class="insight-card">
            <div class="insight-card-header">
                <div class="insight-icon purple">🧠</div>
                <div class="insight-card-title">Pola Emosi</div>
            </div>
            <div class="insight-card-desc">
                Emosi <span class="insight-highlight">{{ $emosiDominan }}</span> paling sering muncul.<br><small style="margin-top:4px;display:block">{!! $pola_emosi !!}</small>
            </div>
        </div>
        <div class="insight-card">
            <div class="insight-card-header">
                <div class="insight-icon blue">🧩</div>
                <div class="insight-card-title">Pola Pikir</div>
            </div>
            <div class="insight-card-desc">
                {!! $pola_aspek !!}
            </div>
        </div>
        <div class="insight-card">
            <div class="insight-card-header">
                <div class="insight-icon green">📈</div>
                <div class="insight-card-title">Konsistensi</div>
            </div>
            <div class="insight-card-desc">
                {{ $pola_konsistensi }}
            </div>
        </div>
    </div>

    {{-- Analisis Mendalam --}}
    <div class="analisis-box">
        <div class="analisis-header">
            <div class="analisis-icon">✨</div>
            <div class="analisis-title">Analisis Mendalam</div>
        </div>
        <p class="analisis-text">{!! $analisis_mendalam !!}</p>
    </div>

</main>

<script>
const chartData = @json($chartData);

// ===== TREN CHART =====
const trenCtx = document.getElementById('trenChart').getContext('2d');
const grad = trenCtx.createLinearGradient(0, 0, 0, 240);
grad.addColorStop(0, 'rgba(168,85,247,0.3)');
grad.addColorStop(1, 'rgba(168,85,247,0)');

let trenChart = new Chart(trenCtx, {
    type: 'line',
    data: {
        labels: chartData.tren.minggu.labels,
        datasets: [{
            data: chartData.tren.minggu.data,
            borderColor: '#a855f7',
            backgroundColor: grad,
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#a855f7',
            pointRadius: 4,
            pointHoverRadius: 7,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#7c6fa0' } },
            y: { grid: { color: 'rgba(168,85,247,0.07)' }, ticks: { font: { size: 11 }, color: '#7c6fa0', stepSize: 1 }, beginAtZero: true }
        }
    }
});

function setPeriod(btn, period) {
    document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    trenChart.data.labels = chartData.tren[period].labels;
    trenChart.data.datasets[0].data = chartData.tren[period].data;
    trenChart.update();
}

// ===== EMOSI DONUT =====
const emosiData = chartData.emosi;
const hasEmosi = emosiData.some(d => d.value > 0);

new Chart(document.getElementById('emosiChart'), {
    type: 'doughnut',
    data: {
        labels: emosiData.map(d => d.label),
        datasets: [{
            data: hasEmosi ? emosiData.map(d => d.value) : [1],
            backgroundColor: hasEmosi ? emosiData.map(d => d.color) : ['#e9d5ff'],
            borderWidth: 0,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '68%',
        plugins: { legend: { display: false }, tooltip: { enabled: hasEmosi } }
    }
});

// Emosi Donut Legend
const emosiLegend = document.getElementById('emosiLegend');
emosiData.forEach(d => {
    emosiLegend.innerHTML += `
        <div class="legend-item">
            <div class="legend-dot" style="background:${d.color}"></div>
            <span>${d.label} (${d.value})</span>
        </div>`;
});

// ===== EMOSI BARS =====
const maxEmosi = Math.max(...emosiData.map(d => d.value), 1);
const emosiBarsEl = document.getElementById('emosiBars');

if (emosiData.length === 0) {
    emosiBarsEl.innerHTML = '<p style="font-size:13px;color:#8a7fa0;text-align:center;padding:20px 0">Belum ada data emosi</p>';
} else {
    emosiData.forEach(d => {
        const pct = Math.round((d.value / maxEmosi) * 100);
        emosiBarsEl.innerHTML += `
            <div class="mood-bar-item">
                <div class="mood-bar-label">${d.label}</div>
                <div class="mood-bar-track">
                    <div class="mood-bar-fill" style="width:${pct}%;background:${d.color}"></div>
                </div>
                <div class="mood-bar-count">${d.value}x</div>
            </div>`;
    });
}
</script>

</body>
</html>