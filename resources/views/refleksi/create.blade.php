<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refleksi Hari Ini — CeritaJa</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { overflow-x: hidden; width: 100%; }

        :root {
            --sidebar-bg: #2d1b5e;
            --sidebar-w: 66px;
            --ink: #1e1b4b;             /* ganti */
            --ink-muted: #7c6fa0; 
            --ink-faint: #c5bcd8;
            --page: #f3eeff;
            --card: #ffffff;
            --accent: #a855f7;
            --accent-soft: #f3e8ff;
            --warm: #e9d5ff;
            --warm-dark: #d8b4fe;
            --border: rgba(123,82,212,0.1);
            --radius: 20px;
            --shadow: 0 2px 8px rgba(28,21,40,0.06), 0 8px 28px rgba(28,21,40,0.05);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--page);
            display: flex;
            min-height: 100vh;
            color: var(--ink);
        }

        /* ───── SIDEBAR ───── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex; flex-direction: column; align-items: center;
            padding: 20px 0 22px;
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 100;
        }

        .sidebar-logo {
            width: 36px; height: 36px;
            background: var(--accent);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; color: white;
            margin-bottom: 34px;
            box-shadow: 0 4px 12px rgba(123,82,212,0.45);
        }

        .sidebar-nav { flex: 1; display: flex; flex-direction: column; gap: 4px; align-items: center; }

        .nav-item {
            width: 40px; height: 40px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.28); font-size: 19px;
            text-decoration: none; transition: all 0.16s;
            position: relative;
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

        /* ───── MAIN ───── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1; padding: 0;
            width: calc(100% - var(--sidebar-w));
            display: flex; flex-direction: column;
        }

        /* ───── HERO HEADER ───── */
        .hero {
            background: var(--sidebar-bg);
            padding: 48px 56px 44px;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; top: -60px; right: -60px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(123,82,212,0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute; bottom: -80px; left: 120px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(180,120,255,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-top { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; }
        .back-btn {
            width: 34px; height: 34px; border-radius: 9px;
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.45); font-size: 19px;
            text-decoration: none; transition: all 0.16s;
        }
        .back-btn:hover { background: rgba(255,255,255,0.14); color: white; }

        .hero-breadcrumb {
            font-size: 12px; color: rgba(255,255,255,0.35);
            letter-spacing: 0.5px;
        }
        .hero-breadcrumb span { color: rgba(255,255,255,0.6); }

        .hero-content { position: relative; z-index: 1; }
        .hero-date {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 12px; color: rgba(255,255,255,0.4);
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            padding: 5px 12px; border-radius: 20px;
            margin-bottom: 16px; letter-spacing: 0.3px;
        }
        .hero-date i { font-size: 13px; color: rgba(123,82,212,0.9); }

        .hero-title {
            font-family: 'Plus Jakarta Sans', serif;
            font-size: 36px; font-weight: 400;
            font-weight: 700;
            color: white; 
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 10px;
        }
        .hero-title em {
            font-weight: 700; 
            color: #c4a8f8; }

        .hero-sub {
            font-size: 14px; color: rgba(255,255,255,0.45);
            font-weight: 300; line-height: 1.6;
            max-width: 460px;
        }

        /* ───── FORM AREA ───── */
        .form-area {
            flex: 1;
            padding: 36px 56px 56px;
            display: grid;
            grid-template-columns: 1fr 260px;
            gap: 24px;
            align-items: start;
        }

        .journal-col { display: flex; flex-direction: column; gap: 18px; }
        .sidebar-col { display: flex; flex-direction: column; gap: 16px; position: sticky; top: 28px; }

        /* ───── ENTRY BLOCK ───── */
        .entry-block {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid rgba(28,21,40,0.07);
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeUp 0.4s ease both;
        }
        .entry-block:nth-child(1) { animation-delay: 0.05s; }
        .entry-block:nth-child(2) { animation-delay: 0.1s; }
        .entry-block:nth-child(3) { animation-delay: 0.15s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .block-header {
            display: flex; align-items: flex-start; gap: 14px;
            padding: 22px 24px 0;
        }
        .block-icon {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; flex-shrink: 0; margin-top: 1px;
        }
        .icon-emosi  { background: #fef3c7; color: #d97706; }
        .icon-pikir  { background: #ede8fb; color: #7b52d4; }
        .icon-aksi   { background: #dcfce7; color: #16a34a; }

        .block-meta { flex: 1; }
        .block-title {
            font-family: 'Plus Jakarta Sans', serif;
            font-size: 17px; font-weight: 500;
            color: var(--ink); line-height: 1.3;
            margin-bottom: 4px;
        }
        .block-hint {
            font-size: 12px; color: var(--ink-muted);
            line-height: 1.5;
        }

        .block-body { padding: 14px 24px 22px; }

        /* ───── TEXTAREA ───── */
        .journal-textarea {
            width: 100%;
            min-height: 110px;
            padding: 14px 16px;
            border: 1.5px solid rgba(28,21,40,0.08);
            border-radius: 13px;
            font-size: 14.5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--ink);
            background: var(--page);
            outline: none;
            line-height: 1.75;
            resize: vertical;
            transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
        }
        .journal-textarea:focus {
            border-color: var(--accent);
            background: white;
            box-shadow: 0 0 0 3px rgba(123,82,212,0.09);
        }
        .journal-textarea::placeholder {
            color: var(--ink-faint);
            font-style: italic;
            font-size: 13.5px;
        }

        .textarea-footer {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: 7px;
        }
        .textarea-tag {
            font-size: 11px; color: 
            var(--ink-faint);
            background: #2d1b5e; 
            padding: 3px 9px;
            border-radius: 20px; 
            font-weight: 500;
        }
        .char-count { font-size: 11px; color: var(--ink-faint); }

        /* ───── SIDEBAR CARDS ───── */
        .side-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid rgba(28,21,40,0.07);
            box-shadow: var(--shadow);
            padding: 20px;
            animation: fadeUp 0.4s ease 0.2s both;
        }

        .side-card-title {
            font-size: 10.5px; font-weight: 600;
            color: var(--ink-muted);
            text-transform: uppercase; letter-spacing: 0.8px;
            margin-bottom: 14px;
            display: flex; align-items: center; gap: 6px;
        }
        .side-card-title i { font-size: 14px; color: var(--accent); }

        .date-input {
            width: 100%; padding: 10px 13px;
            border: 1.5px solid rgba(28,21,40,0.08);
            border-radius: 11px;
            font-size: 13.5px; color: var(--ink);
            background: var(--page); outline: none; font-family: inherit;
            transition: all 0.16s; cursor: pointer;
        }
        .date-input:focus { border-color: var(--accent); background: white; box-shadow: 0 0 0 3px rgba(123,82,212,0.08); }

        /* ───── SUBMIT ───── */
        .submit-card {
            background: var(--sidebar-bg);
            border-radius: var(--radius);
            padding: 22px;
            animation: fadeUp 0.4s ease 0.25s both;
        }

        .btn-simpan {
            width: 100%; padding: 13px;
            border-radius: 13px;
            font-size: 14px; font-weight: 600; color: white;
            background: var(--accent);
            border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: all 0.18s; font-family: inherit;
            box-shadow: 0 4px 14px rgba(123,82,212,0.4);
            letter-spacing: 0.1px;
        }
        .btn-simpan:hover { background: #6b40c8; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(123,82,212,0.5); }
        .btn-simpan:active { transform: none; }

        .btn-subtext {
            text-align: center;
            font-size: 11.5px; color: rgba(255,255,255,0.3);
            margin-top: 10px; font-style: italic;
        }

        .btn-batal {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            width: 100%; padding: 10px;
            margin-top: 8px;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 11px;
            font-size: 13px; color: rgba(255,255,255,0.3);
            background: transparent; cursor: pointer;
            text-decoration: none; font-family: inherit;
            transition: all 0.16s;
        }
        .btn-batal:hover { color: rgba(255,255,255,0.6); border-color: rgba(255,255,255,0.2); }

        /* ───── TIPS ───── */
        .tips-card {
            background: linear-gradient(145deg, #2a1e4a, #1e1535);
            border-radius: var(--radius);
            padding: 20px;
            animation: fadeUp 0.4s ease 0.3s both;
        }
        .tips-label {
            font-size: 10.5px; font-weight: 600;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase; letter-spacing: 0.8px;
            margin-bottom: 12px;
        }
        .tips-list { list-style: none; display: flex; flex-direction: column; gap: 9px; }
        .tips-list li {
            font-size: 12.5px; color: rgba(255,255,255,0.5);
            display: flex; gap: 8px; line-height: 1.5;
        }
        .tips-list li::before { content: '—'; color: rgba(123,82,212,0.7); flex-shrink: 0; }

        /* ───── ERROR ───── */
        .alert-error {
            background: #fff5f5; border: 1px solid #fecaca;
            border-radius: 12px; padding: 11px 16px;
            font-size: 13px; color: #dc2626;
            margin: 24px 56px 0;
            display: flex; align-items: center; gap: 8px;
        }
        .error-msg { font-size: 12px; color: #ef4444; margin-top: 5px; }

        /* ───── PROGRESS LINE ───── */
        .progress-strip {
            display: flex; align-items: center; gap: 0;
            padding: 0 56px; margin-bottom: -8px; margin-top: 32px;
        }
        .prog-step {
            display: flex; align-items: center; gap: 8px;
            font-size: 11.5px; color: var(--ink-muted); font-weight: 500;
        }
        .prog-dot {
            width: 22px; height: 22px; border-radius: 50%;
            background: var(--warm); border: 2px solid var(--warm-dark);
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; color: var(--ink-muted); font-weight: 600;
        }
        .prog-dot.active { background: var(--accent); border-color: var(--accent); color: white; }
        .prog-line {
            flex: 1; height: 1.5px;
            background: var(--warm-dark);
            margin: 0 8px;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo"><i class='bx bx-book-heart'></i></div>
    <nav class="sidebar-nav">
        <a href="/dashboard" class="nav-item"><i class='bx bxs-home'></i><span class="tip">Dashboard</span></a>
        <a href="/refleksi" class="nav-item active"><i class='bx bx-book-open'></i><span class="tip">Refleksi</span></a>
        <a href="/riwayat" class="nav-item"><i class='bx bx-time-five'></i><span class="tip">Riwayat</span></a>
        <a href="/grafik" class="nav-item"><i class='bx bx-line-chart'></i><span class="tip">Grafik</span></a>
    </nav>
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="logout-btn" title="Keluar"><i class='bx bx-log-out'></i></button>
        </form>
    </div>
</aside>

<!-- MAIN -->
<main class="main">

    <!-- HERO HEADER -->
    <div class="hero">
        <div class="hero-top">
            <a href="/dashboard" class="back-btn"><i class='bx bx-chevron-left'></i></a>
            <div class="hero-breadcrumb">Dashboard / <span>Refleksi Baru</span></div>
        </div>
        <div class="hero-content">
            <div class="hero-date"><i class='bx bx-calendar'></i> <span id="heroDate"></span></div>
            <h1 class="hero-title">Gimana hari <em>kamu?</em></h1>
            <p class="hero-sub">Tulis pengalamanmu dengan jujur, tidak ada jawaban benar atau salah.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert-error"><i class='bx bx-error-circle'></i> {{ $errors->first() }}</div>
    @endif

    <!-- PROGRESS -->
    <div class="progress-strip">
        <div class="prog-step"><div class="prog-dot active">1</div> Emosi</div>
        <div class="prog-line"></div>
        <div class="prog-step"><div class="prog-dot">2</div> Pola Pikir</div>
        <div class="prog-line"></div>
        <div class="prog-step"><div class="prog-dot">3</div> Tindakan</div>
        <div class="prog-line"></div>
        <div class="prog-step"><div class="prog-dot">4</div> Simpan</div>
    </div>

    <!-- FORM -->
    <form method="POST" action="/refleksi/store" id="journalForm">
        @csrf
        <div class="form-area">

            <!-- JOURNAL COLUMN -->
            <div class="journal-col">

                <!-- EMOSI -->
                <div class="entry-block">
                    <div class="block-header">
                        <div class="block-icon icon-emosi"><i class='bx bx-heart'></i></div>
                        <div class="block-meta">
                            <div class="block-title">Emosi hari ini</div>
                            <div class="block-hint">Tulis apa pun yang kamu rasakan, tidak perlu satu kata.</div>
                        </div>
                    </div>
                    <div class="block-body">
                        <textarea
                            name="emosi"
                            class="journal-textarea"
                            id="txtEmosi"
                            placeholder="Contoh: senang tapi capek, cemas, lega, hampa, atau campuran perasaan lainnya..."
                            required
                            oninput="updateCount('txtEmosi','cntEmosi')">{{ old('emosi') }}</textarea>
                        <div class="textarea-footer">
                            <span class="textarea-tag">Ekspresi bebas</span>
                            <span class="char-count"><span id="cntEmosi">0</span> karakter</span>
                        </div>
                        @error('emosi')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- POLA PIKIR -->
                <div class="entry-block">
                    <div class="block-header">
                        <div class="block-icon icon-pikir"><i class='bx bx-brain'></i></div>
                        <div class="block-meta">
                            <div class="block-title">Apa yang kamu pikirkan hari ini?</div>
                            <div class="block-hint">Ceritakan cara pikirmu bukan penilaian, tapi pengamatan.</div>
                        </div>
                    </div>
                    <div class="block-body">
                        <textarea
                            name="mindset"
                            class="journal-textarea"
                            id="txtMindset"
                            placeholder="Contoh: aku merasa belum cukup baik, aku terlalu overthinking, atau aku bisa kalau lebih tenang..."
                            required
                            oninput="updateCount('txtMindset','cntMindset')">{{ old('mindset') }}</textarea>
                        <div class="textarea-footer">
                            <span class="textarea-tag">Refleksi pikiran</span>
                            <span class="char-count"><span id="cntMindset">0</span> karakter</span>
                        </div>
                        @error('mindset')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- TINDAKAN -->
                <div class="entry-block">
                    <div class="block-header">
                        <div class="block-icon icon-aksi"><i class='bx bx-run'></i></div>
                        <div class="block-meta">
                            <div class="block-title">Apa yang kamu lakukan hari ini?</div>
                            <div class="block-hint">Hubungkan kondisi emosional dengan perilakumu.</div>
                        </div>
                    </div>
                    <div class="block-body">
                        <textarea
                            name="tindakan"
                            class="journal-textarea"
                            id="txtTindakan"
                            placeholder="Contoh: belajar, menunda tugas, olahraga, tetap mencoba walau capek..."
                            required
                            oninput="updateCount('txtTindakan','cntTindakan')">{{ old('tindakan') }}</textarea>
                        <div class="textarea-footer">
                            <span class="">Perilaku dan Respons</span>
                            <span class="char-count"><span id="cntTindakan">0</span> karakter</span>
                        </div>
                        @error('tindakan')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                </div>

            </div>

            <!-- SIDEBAR COLUMN -->
            <div class="sidebar-col">

                <!-- TANGGAL -->
                <div class="side-card">
                    <div class="side-card-title"><i class='bx bx-calendar-check'></i> Tanggal Refleksi</div>
                    <input type="date" name="tanggal" class="date-input"
                        value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal')<p class="error-msg">{{ $message }}</p>@enderror
                </div>

                <!-- SUBMIT -->
                <div class="submit-card">
                    <button type="submit" class="btn-simpan">
                        <i class='bx bx-save'></i> Simpan Refleksi
                    </button>
                    <p class="btn-subtext">Semua cerita kamu berharga.</p>
                    <a href="/dashboard" class="btn-batal"><i class='bx bx-x'></i> Batal</a>
                </div>

                <!-- TIPS -->
                <div class="tips-card">
                    <div class="tips-label">✦ Tips menulis</div>
                    <ul class="tips-list">
                        <li>Tulis jujur, tanpa menghakimi diri sendiri</li>
                        <li>Fokus pada perasaan, bukan hanya kejadian</li>
                        <li>Tanyakan: Apa yang bisa aku pelajari?</li>
                        <li>Perhatikan hubungan emosi dan tindakanmu</li>
                        <li>Konsisten lebih penting dari sempurna</li>
                    </ul>
                </div>

            </div>

        </div>
    </form>

</main>

<script>
    // Dynamic date in hero
    const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const now = new Date();
    document.getElementById('heroDate').textContent =
        `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

    // Char counter
    function updateCount(textareaId, counterId) {
        const len = document.getElementById(textareaId).value.length;
        document.getElementById(counterId).textContent = len;
    }

    // Init counts from old() values
    ['txtEmosi','txtMindset','txtTindakan'].forEach(id => {
        const el = document.getElementById(id);
        if (el && el.value) {
            const map = { txtEmosi: 'cntEmosi', txtMindset: 'cntMindset', txtTindakan: 'cntTindakan' };
            document.getElementById(map[id]).textContent = el.value.length;
        }
    });

    // Progress step highlight on focus
    const steps = document.querySelectorAll('.prog-dot');
    const textareas = ['txtEmosi','txtMindset','txtTindakan'];
    textareas.forEach((id, i) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('focus', () => {
            steps.forEach((s, j) => s.classList.toggle('active', j === i));
        });
    });
</script>

</body>
</html>