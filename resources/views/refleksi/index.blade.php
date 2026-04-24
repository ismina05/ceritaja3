<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Refleksi - CeritaJa</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 22px;
            font-weight: 700;
        }

        .page-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .btn-tambah {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #a855f7, #7c3aed);
            color: white;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(168,85,247,0.3);
        }

        .btn-tambah:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(168,85,247,0.4);
        }

        /* ===== FILTER BAR ===== */
        .filter-bar {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 16px 20px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-wrapper {
            flex: 1;
            min-width: 200px;
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: var(--text-muted);
        }

        .search-wrapper input {
            width: 100%;
            padding: 9px 14px 9px 36px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            color: var(--text-primary);
            background: var(--page-bg);
            outline: none;
            font-family: inherit;
            transition: border-color 0.2s;
        }

        .search-wrapper input:focus {
            border-color: var(--accent);
            background: white;
        }

        .filter-select {
            padding: 9px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            color: var(--text-primary);
            background: var(--page-bg);
            outline: none;
            font-family: inherit;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .filter-select:focus { border-color: var(--accent); }

        .sort-tabs {
            display: flex;
            gap: 4px;
            background: var(--page-bg);
            padding: 4px;
            border-radius: 10px;
        }

        .sort-tab {
            padding: 6px 14px;
            border-radius: 7px;
            border: none;
            background: transparent;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .sort-tab.active {
            background: white;
            color: var(--accent);
            box-shadow: 0 1px 4px rgba(168,85,247,0.15);
        }

        /* ===== SUCCESS ALERT ===== */
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
            color: #166534;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--border);
            padding: 60px 40px;
            text-align: center;
        }

        .empty-icon {
            font-size: 48px;
            color: var(--accent-light);
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        /* ===== DATE GROUP ===== */
        .date-group {
            margin-bottom: 20px;
        }

        .date-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .date-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ===== REFLEKSI CARD ===== */
        .refleksi-card {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 18px 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: all 0.2s;
        }

        .refleksi-card:hover {
            border-color: var(--accent);
            box-shadow: 0 4px 16px rgba(168,85,247,0.08);
            transform: translateY(-1px);
        }

        .card-mood {
            font-size: 28px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .card-body { flex: 1; min-width: 0; }

        .card-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-preview {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.5;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: 10px;
        }

        .card-tags {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        .tag-mood { background: #faf5ff; color: #7c3aed; }
        .tag-aspek { background: #eff6ff; color: #1d4ed8; }
        .tag-kategori { background: #f0fdf4; color: #166534; }

        .card-actions {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex-shrink: 0;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            background: var(--accent-light);
            color: var(--accent);
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
        }

        .btn-edit:hover { background: #d8b4fe; }

        .btn-hapus {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            background: #fef2f2;
            color: #dc2626;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
        }

        .btn-hapus:hover { background: #fecaca; }

        /* ===== MODAL KONFIRMASI ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 200;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show { display: flex; }

        .modal-box {
            background: white;
            border-radius: 20px;
            padding: 32px;
            max-width: 380px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .modal-icon {
            font-size: 40px;
            margin-bottom: 12px;
        }

        .modal-box h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .modal-box p {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-modal-cancel {
            padding: 10px 24px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
            background: transparent;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
        }

        .btn-modal-cancel:hover { background: var(--page-bg); }

        .btn-modal-hapus {
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: white;
            background: #ef4444;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
        }

        .btn-modal-hapus:hover { background: #dc2626; }
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
        <a href="/riwayat" class="nav-item active">
            <i class='bx bx-time-five'></i><span class="tooltip">Riwayat</span>
        </a>
        <a href="/grafik" class="nav-item">
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
            <h1>Riwayat Refleksi</h1>
            <p>Semua catatan refleksimu tersimpan di sini</p>
        </div>
        <a href="/refleksi" class="btn-tambah">
            <i class='bx bx-plus'></i> Tambah Refleksi
        </a>
    </div>

    {{-- Success --}}
    @if(session('success'))
        <div class="alert-success">
            <i class='bx bx-check-circle'></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Bar --}}
    <div class="filter-bar">
        <div class="search-wrapper">
            <i class='bx bx-search'></i>
            <input type="text" id="searchInput" placeholder="Cari refleksi..." oninput="filterCards()">
        </div>

        <select class="filter-select" id="filterKategori" onchange="filterCards()">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->nama_kategori }}">{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>

        <select class="filter-select" id="filterAspek" onchange="filterCards()">
            <option value="">Semua Aspek</option>
            @foreach($aspeks as $aspek)
                <option value="{{ $aspek->nama_aspek }}">{{ $aspek->nama_aspek }}</option>
            @endforeach
        </select>

        <div class="sort-tabs">
            <button class="sort-tab active" onclick="setSort(this, 'terbaru')">Terbaru</button>
            <button class="sort-tab" onclick="setSort(this, 'semua')">Semua</button>
        </div>
    </div>

    {{-- Content --}}
    @if($refleksis->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class='bx bx-book-open'></i></div>
            <h3>Belum ada refleksi</h3>
            <p>Mulai catat perjalanan harianmu sekarang</p>
            <a href="/refleksi" class="btn-tambah">
                <i class='bx bx-plus'></i> Tambah Refleksi Pertama
            </a>
        </div>
    @else
        <div id="refleksiList">
            @php
                $grouped = $refleksis->groupBy(function($item) {
                    $tanggal = \Carbon\Carbon::parse($item->tanggal);
                    if ($tanggal->isToday()) return 'Hari ini · ' . $tanggal->translatedFormat('l, d F Y');
                    if ($tanggal->isYesterday()) return 'Kemarin · ' . $tanggal->translatedFormat('l, d F Y');
                    return $tanggal->translatedFormat('l, d F Y');
                });
            @endphp

            @foreach($grouped as $tanggal => $items)
                <div class="date-group">
                    <div class="date-label">{{ $tanggal }}</div>

                    @foreach($items as $r)
                        <div class="refleksi-card"
                            data-judul="{{ strtolower($r->judul) }}"
                            data-kategori="{{ $r->kategori->nama_kategori ?? '' }}"
                            data-aspek="{{ $r->aspek->nama_aspek ?? '' }}">

                            <div class="card-mood">{{ $r->mood->emoji ?? '📝' }}</div>

                            <div class="card-body">
                                <div class="card-title">{{ $r->judul }}</div>
                                <div class="card-preview">{{ $r->isi_refleksi }}</div>
                                <div class="card-tags">
                                    @if($r->mood)
                                        <span class="tag tag-mood">{{ $r->mood->nama_mood }}</span>
                                    @endif
                                    @if($r->aspek)
                                        <span class="tag tag-aspek">{{ $r->aspek->nama_aspek }}</span>
                                    @endif
                                    @if($r->kategori)
                                        <span class="tag tag-kategori">{{ $r->kategori->nama_kategori }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="card-actions">
                                <a href="/refleksi/{{ $r->id }}/edit" class="btn-edit">
                                    <i class='bx bx-edit-alt'></i> Edit
                                </a>
                                <button class="btn-hapus" onclick="confirmDelete({{ $r->id }}, '{{ addslashes($r->judul) }}')">
                                    <i class='bx bx-trash'></i> Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif

</main>

{{-- ===== MODAL HAPUS ===== --}}
<div class="modal-overlay" id="modalHapus">
    <div class="modal-box">
        <div class="modal-icon">🗑️</div>
        <h3>Hapus Refleksi?</h3>
        <p id="modalDesc">Refleksi ini akan dihapus permanen dan tidak bisa dikembalikan.</p>
        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="closeModal()">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modal-hapus">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, judul) {
    document.getElementById('modalDesc').textContent = `"${judul}" akan dihapus permanen.`;
    document.getElementById('deleteForm').action = `/refleksi/${id}`;
    document.getElementById('modalHapus').classList.add('show');
}

function closeModal() {
    document.getElementById('modalHapus').classList.remove('show');
}

function filterCards() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const kategori = document.getElementById('filterKategori').value.toLowerCase();
    const aspek = document.getElementById('filterAspek').value.toLowerCase();

    document.querySelectorAll('.refleksi-card').forEach(card => {
        const judul = card.dataset.judul || '';
        const kat = card.dataset.kategori.toLowerCase();
        const asp = card.dataset.aspek.toLowerCase();

        const matchSearch = judul.includes(search);
        const matchKat = !kategori || kat === kategori;
        const matchAsp = !aspek || asp === aspek;

        card.style.display = (matchSearch && matchKat && matchAsp) ? '' : 'none';
    });
}

function setSort(btn, type) {
    document.querySelectorAll('.sort-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

// Tutup modal kalau klik di luar
document.getElementById('modalHapus').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

</body>
</html>