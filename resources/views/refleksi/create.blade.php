<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Refleksi - CeritaJa</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
            --border: rgba(168,85,247,0.15);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--page-bg);
            display: flex;
            min-height: 100vh;
            color: var(--text-primary);
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
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

        .form-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 32px;
            border: 1px solid var(--border);
            width: 100%;
            max-width: 1000px;   /* bisa kamu gedein */
            margin: 0 auto; 
        }

        /* ===== HEADER ===== */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .page-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ===== FORM CARD ===== */
        .form-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 32px;
            border: 1px solid var(--border);
            max-width: 780px;
        }

        /* ===== MOOD SELECTOR ===== */
        .mood-section {
            margin-bottom: 28px;
        }

        .section-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .mood-grid {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .mood-option {
            display: none;
        }

        .mood-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 12px 16px;
            border-radius: 14px;
            border: 2px solid var(--border);
            cursor: pointer;
            transition: all 0.2s;
            min-width: 72px;
        }

        .mood-label:hover {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .mood-option:checked + .mood-label {
            border-color: var(--accent);
            background: var(--accent-light);
            box-shadow: 0 0 0 3px rgba(168,85,247,0.15);
        }

        .mood-emoji { font-size: 24px; }
        .mood-name { font-size: 11px; font-weight: 500; color: var(--text-muted); }

        /* ===== FORM GRID ===== */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .form-group select,
        .form-group input[type="date"] {
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            color: var(--text-primary);
            background: var(--page-bg);
            outline: none;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .form-group select:focus,
        .form-group input[type="date"]:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(168,85,247,0.1);
            background: white;
        }

        /* ===== JUDUL ===== */
        .judul-group {
            margin-bottom: 20px;
        }

        .judul-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 15px;
            font-weight: 500;
            color: var(--text-primary);
            background: var(--page-bg);
            outline: none;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .judul-group input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(168,85,247,0.1);
            background: white;
        }

        .judul-group input::placeholder { color: #b4a8cc; }

        /* ===== TEXTAREA ===== */
        .isi-group {
            margin-bottom: 24px;
        }

        .isi-group textarea {
            width: 100%;
            min-height: 160px;
            padding: 16px;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            font-size: 14px;
            color: var(--text-primary);
            background: var(--page-bg);
            outline: none;
            font-family: inherit;
            line-height: 1.7;
            resize: vertical;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .isi-group textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(168,85,247,0.1);
            background: white;
        }

        .isi-group textarea::placeholder { color: #b4a8cc; }

        .char-count {
            text-align: right;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 6px;
        }

        /* ===== ERROR ===== */
        .error-msg {
            font-size: 12px;
            color: #ef4444;
            margin-top: 4px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13px;
            color: #dc2626;
            margin-bottom: 20px;
        }

        /* ===== ACTIONS ===== */
        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .btn-cancel {
            padding: 11px 24px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
            background: transparent;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-cancel:hover {
            background: var(--page-bg);
            border-color: var(--accent);
            color: var(--accent);
        }

        .btn-simpan {
            padding: 11px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, #a855f7, #7c3aed);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            font-family: inherit;
            box-shadow: 0 4px 12px rgba(168,85,247,0.3);
        }

        .btn-simpan:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(168,85,247,0.4);
        }

        .btn-simpan:active { transform: translateY(0); }

        /* ===== DIVIDER ===== */
        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 24px 0;
        }
    </style>
</head>
<body>

{{-- ===== SIDEBAR ===== --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <i class='bx bx-book-heart'></i>
    </div>
    <nav class="sidebar-nav">
        <a href="/dashboard" class="nav-item">
            <i class='bx bxs-home'></i>
            <span class="tooltip">Dashboard</span>
        </a>
        <a href="/refleksi" class="nav-item active">
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

{{-- ===== MAIN ===== --}}
<main class="main">
    <div class="page-header">
        <div>
            <h1>Tambah Refleksi</h1>
            <p>Catat pengalaman dan perasaanmu hari ini</p>
        </div>
    </div>

    <div class="form-card">

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/refleksi/store">
            @csrf

            {{-- MOOD --}}
            <div class="mood-section">
                <div class="section-label">Bagaimana perasaanmu?</div>
                <div class="mood-grid">
                    @foreach($moods as $mood)
                        <input type="radio" name="mood_id" id="mood_{{ $mood->id }}"
                            value="{{ $mood->id }}" class="mood-option"
                            {{ old('mood_id') == $mood->id ? 'checked' : '' }} required>
                        <label for="mood_{{ $mood->id }}" class="mood-label">
                            <span class="mood-emoji">{{ $mood->emoji }}</span>
                            <span class="mood-name">{{ $mood->nama_mood }}</span>
                        </label>
                    @endforeach
                </div>
                @error('mood_id')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            <hr class="divider">

            {{-- JUDUL --}}
            <div class="judul-group">
                <div class="section-label">Judul Refleksi</div>
                <input type="text" name="judul"
                    placeholder="Beri judul singkat untuk refleksimu..."
                    value="{{ old('judul') }}" required>
                @error('judul')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            {{-- ISI --}}
            <div class="isi-group">
                <div class="section-label">Ceritakan Refleksimu</div>
                <textarea name="isi_refleksi" id="isiRefleksi"
                    placeholder="Apa yang kamu rasakan, pikirkan, atau alami hari ini? Tulis dengan bebas..."
                    required oninput="updateCharCount(this)">{{ old('isi_refleksi') }}</textarea>
                <div class="char-count"><span id="charCount">0</span> karakter</div>
                @error('isi_refleksi')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            <hr class="divider">

            {{-- KATEGORI, ASPEK, TANGGAL --}}
            <div class="form-grid">
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" required>
                        <option value="" disabled selected>Pilih kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}"
                                {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Aspek</label>
                    <select name="aspek_id" required>
                        <option value="" disabled selected>Pilih aspek</option>
                        @foreach($aspeks as $aspek)
                            <option value="{{ $aspek->id }}"
                                {{ old('aspek_id') == $aspek->id ? 'selected' : '' }}>
                                {{ $aspek->nama_aspek }}
                            </option>
                        @endforeach
                    </select>
                    @error('aspek_id')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal"
                        value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="form-actions">
                <a href="/dashboard" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-simpan">
                    <i class='bx bx-save'></i> Simpan Refleksi
                </button>
            </div>

        </form>
    </div>
</main>

<script>
function updateCharCount(el) {
    document.getElementById('charCount').textContent = el.value.length;
}
// Init count
document.addEventListener('DOMContentLoaded', () => {
    const ta = document.getElementById('isiRefleksi');
    if (ta) document.getElementById('charCount').textContent = ta.value.length;
});
</script>

</body>
</html>
