<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --red: #ED1C24; --yellow: #FFD700; --green: #00A651; }
        body { background-color: #f4f7f6; }

        .header-top {
            background-color: var(--red); height: 60px;
            display: flex; align-items: center; padding: 0 15px;
            position: sticky; top: 0; z-index: 1000;
            border-bottom: 4px solid var(--yellow);
        }
        .btn-hamburger { background: var(--red); color: white; border: 2px solid var(--yellow); padding: 5px 12px; border-radius: 5px; cursor: pointer; }
        .offcanvas { width: 280px !important; background: var(--red); color: white; border-right: 5px solid var(--yellow); }
        .nav-link { color: white; font-weight: bold; padding: 15px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { background: var(--yellow); color: var(--red); }

        /* STAT CARDS */
        .stat-card {
            border-radius: 15px; padding: 20px; color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card.merah  { background: linear-gradient(135deg, #ED1C24, #a00); }
        .stat-card.hijau  { background: linear-gradient(135deg, #00A651, #007a3d); }
        .stat-card.kuning { background: linear-gradient(135deg, #f39c12, #d68910); }
        .stat-card.biru   { background: linear-gradient(135deg, #2980b9, #1a5276); }
        .stat-angka { font-size: 2.2rem; font-weight: 900; }
        .stat-label { font-size: 0.8rem; opacity: 0.9; margin-top: 4px; }

        /* CARDS */
        .card-custom {
            border-radius: 15px; border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .card-header-red {
            background: linear-gradient(135deg, var(--red), #a00);
            color: white; border-radius: 15px 15px 0 0 !important;
            padding: 14px 20px; font-weight: bold;
        }

        /* RANKING */
        .menu-rank {
            display: flex; align-items: center;
            padding: 10px 0; border-bottom: 1px solid #f0f0f0;
        }
        .menu-rank:last-child { border-bottom: none; }
        .rank-number {
            width: 30px; height: 30px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 13px;
            margin-right: 12px; flex-shrink: 0;
        }
        .rank-1 { background: #FFD700; color: #333; }
        .rank-2 { background: #C0C0C0; color: #333; }
        .rank-3 { background: #CD7F32; color: white; }
        .rank-other { background: #eee; color: #666; }

        .progress-menu {
            height: 8px; border-radius: 10px;
            background: #eee; margin-top: 4px;
        }
        .progress-fill {
            height: 100%; border-radius: 10px;
            background: linear-gradient(90deg, var(--red), var(--yellow));
        }

        /* STATUS */
        .status-ai    { background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 13px; }
        .status-rules { background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 13px; }

        /* TRANSAKSI */
        .transaksi-item {
            padding: 10px 12px; background: #f8f9fa;
            border-radius: 8px; margin-bottom: 6px; font-size: 13px;
        }

        .loading-box {
            text-align: center; padding: 40px; color: #aaa;
        }

        .api-offline {
            background: #fff3cd; border: 1px solid #ffc107;
            border-radius: 10px; padding: 20px; text-align: center;
        }

        .realtime-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #00A651; display: inline-block;
            animation: blink 1.5s infinite; margin-right: 5px;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header-top shadow-sm justify-content-between">
    <div class="d-flex align-items-center">
        <button class="btn-hamburger" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#sidebarAdmin">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="text-white ms-3 mb-0 fw-bold">
            PUTRA SUNDA <small class="text-warning d-none d-sm-inline">AI</small>
        </h5>
    </div>
    <div class="pe-2 d-flex align-items-center gap-2">
        <span id="status-api" class="badge bg-secondary">
            <i class="fas fa-circle-notch fa-spin me-1"></i> Menghubungi AI...
        </span>
        <a href="<?= base_url('/') ?>" target="_blank"
           class="btn btn-outline-warning btn-sm fw-bold border-2 rounded-pill px-3">
            <i class="fas fa-home"></i>
        </a>
    </div>
</div>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarAdmin">
    <div class="offcanvas-header border-bottom border-white border-opacity-10">
        <h5 class="offcanvas-title fw-bold text-white">
            <i class="fas fa-user-shield me-2"></i> MENU ADMIN
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0 d-flex flex-column">
        <nav class="nav flex-column">
            <a class="nav-link" href="<?= base_url('admin') ?>">
                <i class="fas fa-shopping-cart me-2"></i> Pesanan Masuk
            </a>
            <a class="nav-link" href="<?= base_url('admin/menu') ?>">
                <i class="fas fa-utensils me-2"></i> Manajemen Menu
            </a>
            <a class="nav-link" href="<?= base_url('admin/laporan') ?>">
                <i class="fas fa-file-invoice-dollar me-2"></i> Laporan Harian
            </a>
            <a class="nav-link active" href="<?= base_url('admin/ai_dashboard') ?>">
                <i class="fas fa-brain me-2"></i> Dashboard AI
            </a>
        </nav>
        <div class="mt-auto">
            <button class="border-0 text-white w-100 p-3 fw-bold"
                    style="background:rgba(0,0,0,0.2)"
                    onclick="confirmLogout('<?= base_url('auth/logout') ?>')">
                <i class="fas fa-sign-out-alt me-2"></i> LOGOUT
            </button>
        </div>
    </div>
</div>

<!-- MAIN -->
<div class="container-fluid py-4 px-4">

    <!-- JUDUL -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-brain text-danger me-2"></i>Dashboard AI Recommendation
            </h4>
            <small class="text-muted">
                <span class="realtime-dot"></span>
                Live · <span id="waktu-update">--:--:--</span> WIB
            </small>
        </div>
        <button class="btn btn-outline-danger btn-sm fw-bold rounded-pill px-3"
                onclick="refreshData()">
            <i class="fas fa-sync-alt me-1"></i> Refresh
        </button>
    </div>

    <!-- STAT CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card merah">
                <div class="stat-angka" id="total-transaksi">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <div class="stat-label">Total Transaksi Dipelajari</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card hijau">
                <div class="stat-angka" id="total-menu-unik">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <div class="stat-label">Menu Unik Terdeteksi</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card kuning">
                <div class="stat-angka" id="menu-terpopuler"
                     style="font-size:1rem; padding-top:8px;">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <div class="stat-label">Menu #1 Terpopuler</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card biru">
                <div class="stat-angka" id="mode-ai" style="font-size:1.5rem; padding-top:8px;">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <div class="stat-label">Mode Rekomendasi Aktif</div>
            </div>
        </div>
    </div>

    <!-- GRAFIK + RANKING -->
    <div class="row g-3 mb-4">

        <!-- Grafik Bar -->
        <div class="col-md-7">
            <div class="card card-custom">
                <div class="card-header-red">
                    <i class="fas fa-chart-bar me-2"></i>Top Menu Terpopuler
                </div>
                <div class="card-body">
                    <div id="loading-chart" class="loading-box">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                        <p class="mt-2 mb-0">Memuat data dari AI...</p>
                    </div>
                    <canvas id="chartMenu" style="display:none;"></canvas>
                </div>
            </div>
        </div>

        <!-- Ranking -->
        <div class="col-md-5">
            <div class="card card-custom">
                <div class="card-header-red">
                    <i class="fas fa-trophy me-2"></i>Ranking Menu
                </div>
                <div class="card-body" id="ranking-menu">
                    <div class="loading-box">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                        <p class="mt-2 mb-0">Memuat ranking...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TEST REKOMENDASI + INFO -->
    <div class="row g-3 mb-4">

        <!-- Test Rekomendasi -->
        <div class="col-md-6">
            <div class="card card-custom">
                <div class="card-header-red">
                    <i class="fas fa-magic me-2"></i>Test Rekomendasi AI
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        Masukkan nama menu untuk melihat rekomendasi dari AI:
                    </p>
                    <div class="input-group mb-3">
                        <input type="text" id="input-test-menu"
                               class="form-control"
                               placeholder="Contoh: Indomie Goreng Telur"
                               style="border-radius:10px 0 0 10px;">
                        <button class="btn btn-danger fw-bold"
                                onclick="testRekomendasi()"
                                style="border-radius:0 10px 10px 0;">
                            <i class="fas fa-search me-1"></i> Cek
                        </button>
                    </div>

                    <!-- Hasil -->
                    <div id="hasil-test" style="display:none;">
                        <div class="p-3 rounded-3"
                             style="background:#f8f9fa; border-left:4px solid var(--green);">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Menu:</strong>
                                <span id="test-menu-nama" class="badge bg-danger px-3"></span>
                            </div>
                            <div class="mb-2">
                                <strong>Rekomendasi AI:</strong>
                                <div id="test-rekomendasi" class="mt-1"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <strong>Sumber:</strong>
                                <span id="test-sumber"></span>
                            </div>
                        </div>
                    </div>

                    <div id="test-error" style="display:none;" class="api-offline">
                        <i class="fas fa-plug text-warning fa-2x mb-2"></i>
                        <p class="mb-0 fw-bold">Tidak bisa terhubung ke AI Server</p>
                        <small class="text-muted">Pastikan uvicorn sudah berjalan</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Sistem -->
        <div class="col-md-6">
            <div class="card card-custom">
                <div class="card-header-red">
                    <i class="fas fa-info-circle me-2"></i>Informasi Sistem AI
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-3">
                        <tr>
                            <td class="text-muted">Versi AI</td>
                            <td><span class="badge bg-success">v2.0.0</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Algoritma</td>
                            <td><strong>Collaborative Filtering</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Min. Data</td>
                            <td><strong>3 transaksi per menu</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Fallback</td>
                            <td><strong>Rule-Based</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Database</td>
                            <td><strong>SQLite (orders.db)</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">AI Server</td>
                            <td>
                                <span id="info-server" class="badge bg-secondary">
                                    Mengecek...
                                </span>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-danger w-100 fw-bold"
                                onclick="refreshData()">
                            <i class="fas fa-sync-alt me-1"></i> Refresh Data
                        </button>
                        <button class="btn btn-sm btn-outline-warning w-100 fw-bold"
                                onclick="bukaModalResetAI()">
                            <i class="fas fa-trash me-1"></i> Reset AI Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIWAYAT TRANSAKSI -->
    <div class="row g-3">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header-red d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-history me-2"></i>Riwayat Transaksi Dipelajari AI
                    </span>
                    <span id="badge-total" class="badge bg-light text-dark">-</span>
                </div>
                <div class="card-body" id="riwayat-transaksi">
                    <div class="loading-box">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                        <p class="mt-2 mb-0">Memuat riwayat...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Reset AI -->
<div class="modal fade" id="modalResetAI" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius:15px;">
            <div class="modal-body p-4 text-center">
                <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                <h5 class="fw-bold">Reset Data AI?</h5>
                <p class="text-muted small">
                    Semua data pembelajaran AI akan dihapus.
                    AI akan kembali ke mode Rule-Based.
                </p>
                <div class="d-flex gap-2">
                    <button class="btn btn-light w-100 fw-bold"
                            data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-danger w-100 fw-bold"
                            onclick="resetDataAI()">Hapus!</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sukses Reset AI -->
<div class="modal fade" id="modalSuksesAI" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius:15px;">
            <div class="modal-body p-4 text-center">
                <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                <h5 class="fw-bold text-success">Reset Berhasil!</h5>
                <p class="text-muted small">
                    Data AI sudah dihapus. AI kembali ke mode Rule-Based.
                </p>
                <button class="btn btn-success w-100 fw-bold"
                        onclick="location.reload()" style="border-radius:10px;">
                    <i class="fas fa-sync-alt me-1"></i> Muat Ulang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Logout -->
<div class="modal fade" id="modalLogout" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius:15px;">
            <div class="modal-body p-4 text-center">
                <i class="fas fa-question-circle text-warning fa-3x mb-3"></i>
                <h5 class="fw-bold">Logout?</h5>
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-light w-100 fw-bold"
                            data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="logoutLink"
                       class="btn btn-danger w-100 fw-bold">Ya</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const API_URL = 'http://127.0.0.1:8000';
let chartInstance = null;

// ============================================
// REAL-TIME JAM
// ============================================
function updateJam() {
    const now = new Date();
    const jam = [
        String(now.getHours()).padStart(2,'0'),
        String(now.getMinutes()).padStart(2,'0'),
        String(now.getSeconds()).padStart(2,'0')
    ].join(':');
    const el = document.getElementById('waktu-update');
    if (el) el.innerText = jam;
}
setInterval(updateJam, 1000);
updateJam();

// ============================================
// LOAD DATA SAAT HALAMAN DIBUKA
// ============================================
window.onload = function() {
    loadStats();
    loadRiwayat();
};

// ============================================
// LOAD STATISTIK DARI FASTAPI
// ============================================
async function loadStats() {
    try {
        const res = await fetch(`${API_URL}/stats`);
        if (!res.ok) throw new Error('API Error');
        const data = await res.json();

        // Status API online
        document.getElementById('status-api').innerHTML =
            '<i class="fas fa-circle text-success me-1"></i> AI Online';
        document.getElementById('status-api').className = 'badge bg-success';
        document.getElementById('info-server').innerHTML =
            '127.0.0.1:8000 ✅';
        document.getElementById('info-server').className = 'badge bg-success';

        // Isi stat cards
        document.getElementById('total-transaksi').innerText =
            data.total_transaksi;
        document.getElementById('total-menu-unik').innerText =
            data.top_5_menu_terpopuler.length + '+';
        document.getElementById('menu-terpopuler').innerText =
            data.top_5_menu_terpopuler.length > 0
            ? data.top_5_menu_terpopuler[0].menu : '-';

        const isAI = data.status_ai.includes('nyata');
        document.getElementById('mode-ai').innerHTML =
            isAI ? '🧠 AI Aktif' : '📋 Rule-Based';

        // Render grafik & ranking
        renderChart(data.top_5_menu_terpopuler);
        renderRanking(data.top_5_menu_terpopuler);

    } catch (err) {
        // API offline
        document.getElementById('status-api').innerHTML =
            '<i class="fas fa-times-circle me-1"></i> AI Offline';
        document.getElementById('status-api').className = 'badge bg-danger';
        document.getElementById('info-server').innerHTML = 'Tidak terhubung ❌';
        document.getElementById('info-server').className = 'badge bg-danger';
        document.getElementById('total-transaksi').innerText = '?';
        document.getElementById('total-menu-unik').innerText = '?';
        document.getElementById('menu-terpopuler').innerText = 'Offline';
        document.getElementById('mode-ai').innerHTML = '❌ Off';

        document.getElementById('loading-chart').innerHTML = `
            <div class="api-offline">
                <i class="fas fa-plug fa-2x text-danger mb-2"></i>
                <p class="fw-bold mb-1">AI Server Tidak Terhubung</p>
                <small class="text-muted">Jalankan: uvicorn main:app --reload</small>
            </div>`;
        document.getElementById('ranking-menu').innerHTML = `
            <div class="api-offline text-center">
                <i class="fas fa-plug fa-2x text-danger mb-2"></i>
                <p class="mb-0">AI Server Offline</p>
            </div>`;
    }
}

// ============================================
// RENDER GRAFIK
// ============================================
function renderChart(menuData) {
    document.getElementById('loading-chart').style.display = 'none';
    const canvas = document.getElementById('chartMenu');
    canvas.style.display = 'block';

    const warna = [
        '#ED1C24','#FF6B6B','#FF9F43','#FFD700',
        '#00A651','#26de81','#2980b9','#6c5ce7'
    ];

    if (chartInstance) chartInstance.destroy();

    chartInstance = new Chart(canvas, {
        type: 'bar',
        data: {
            labels: menuData.map(d => d.menu),
            datasets: [{
                label: 'Jumlah Dipesan',
                data: menuData.map(d => d.jumlah),
                backgroundColor: warna.slice(0, menuData.length),
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: { label: ctx => ` Dipesan ${ctx.raw}x` }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f0f0f0' } },
                x: { ticks: { maxRotation: 30, font: { size: 11 } }, grid: { display: false } }
            }
        }
    });
}

// ============================================
// RENDER RANKING
// ============================================
function renderRanking(menuData) {
    const container = document.getElementById('ranking-menu');
    if (menuData.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                Belum ada data. Buat pesanan dulu!
            </div>`;
        return;
    }

    const max = menuData[0].jumlah;
    let html  = '';
    menuData.forEach((item, i) => {
        const rankClass = i === 0 ? 'rank-1' : i === 1 ? 'rank-2' : i === 2 ? 'rank-3' : 'rank-other';
        const persen    = Math.round((item.jumlah / max) * 100);
        html += `
            <div class="menu-rank">
                <div class="rank-number ${rankClass}">${i + 1}</div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold" style="font-size:13px;">${item.menu}</span>
                        <span class="badge bg-danger">${item.jumlah}x</span>
                    </div>
                    <div class="progress-menu">
                        <div class="progress-fill" style="width:${persen}%"></div>
                    </div>
                </div>
            </div>`;
    });
    container.innerHTML = html;
}

// ============================================
// LOAD RIWAYAT TRANSAKSI
// ============================================
async function loadRiwayat() {
    try {
        const res  = await fetch(`${API_URL}/riwayat`);
        if (!res.ok) throw new Error();
        const data = await res.json();

        document.getElementById('badge-total').innerText =
            `${data.total} transaksi`;

        if (data.riwayat.length === 0) {
            document.getElementById('riwayat-transaksi').innerHTML =
                '<p class="text-muted text-center py-3">Belum ada transaksi.</p>';
            return;
        }

        let html = '<div class="row g-2">';
        data.riwayat.forEach((t, i) => {
            const items = t.items.map(item =>
                `<span class="badge bg-light text-dark border me-1 mb-1">${item}</span>`
            ).join('');
            html += `
                <div class="col-md-6">
                    <div class="transaksi-item">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted fw-bold">
                                <i class="fas fa-receipt me-1"></i>
                                Transaksi #${data.total - i}
                            </small>
                            <small class="text-muted">${t.waktu}</small>
                        </div>
                        <div>${items}</div>
                    </div>
                </div>`;
        });
        html += '</div>';
        document.getElementById('riwayat-transaksi').innerHTML = html;

    } catch {
        document.getElementById('riwayat-transaksi').innerHTML =
            '<p class="text-muted text-center py-3">Tidak bisa memuat riwayat.</p>';
    }
}

// ============================================
// TEST REKOMENDASI
// ============================================
async function testRekomendasi() {
    const menu = document.getElementById('input-test-menu').value.trim();
    if (!menu) return;

    document.getElementById('hasil-test').style.display = 'none';
    document.getElementById('test-error').style.display = 'none';

    try {
        const res  = await fetch(`${API_URL}/recommend`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ menu })
        });
        const data = await res.json();

        document.getElementById('test-menu-nama').innerText = data.menu_dipilih;
        document.getElementById('test-rekomendasi').innerHTML =
            data.rekomendasi.map(r =>
                `<span class="badge bg-success me-1 p-2">${r}</span>`
            ).join('');

        const sumberEl = document.getElementById('test-sumber');
        sumberEl.innerText   = data.sumber;
        sumberEl.className   = data.sumber.includes('AI') ? 'status-ai' : 'status-rules';

        document.getElementById('hasil-test').style.display = 'block';
    } catch {
        document.getElementById('test-error').style.display = 'block';
    }
}

// Enter key untuk test
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('input-test-menu')
        .addEventListener('keypress', e => {
            if (e.key === 'Enter') testRekomendasi();
        });
});

// ============================================
// REFRESH DATA
// ============================================
function refreshData() {
    loadStats();
    loadRiwayat();
}

// ============================================
// RESET DATA AI
// ============================================
function bukaModalResetAI() {
    new bootstrap.Modal(document.getElementById('modalResetAI')).show();
}

async function resetDataAI() {
    bootstrap.Modal.getInstance(document.getElementById('modalResetAI')).hide();
    try {
        const res  = await fetch(`${API_URL}/reset`, { method: 'DELETE' });
        const data = await res.json();
        if (data.status === 'success' || res.ok) {
            new bootstrap.Modal(document.getElementById('modalSuksesAI')).show();
        }
    } catch {
        alert('Gagal reset. Pastikan AI server jalan.');
    }
}

// ============================================
// LOGOUT
// ============================================
function confirmLogout(url) {
    document.getElementById('logoutLink').setAttribute('href', url);
    new bootstrap.Modal(document.getElementById('modalLogout')).show();
}
</script>
<!-- NOTIFIKASI PESANAN BARU -->
<script>
(function() {
    let lastCount   = 0;
    let isFirstLoad = true;
    let unlocked    = false;

    // Pakai file lokal
    const snd = new Audio('<?= base_url('sounds/notif.mp3') ?>');
    snd.preload = 'auto';

    // Unlock audio saat user pertama kali klik halaman
    document.addEventListener('click', function() {
        if (!unlocked) {
            unlocked    = true;
            snd.volume  = 0;
            snd.play().then(() => {
                snd.pause();
                snd.currentTime = 0;
                snd.volume      = 1;
                console.log('✅ Audio unlocked');
            }).catch(e => console.log('Unlock gagal:', e));
        }
    }, { once: true });

    function bunyikan() {
        snd.currentTime = 0;
        snd.volume      = 1;
        snd.play().catch(e => console.log('Play gagal:', e));
        tampilToast();
    }

    function tampilToast() {
        const old = document.getElementById('toast-pesanan-baru');
        if (old) old.remove();

        const toast = document.createElement('div');
        toast.id    = 'toast-pesanan-baru';
        toast.style.cssText = `
            position: fixed; top: 70px; right: 20px; z-index: 99999;
            background: #ED1C24; color: white;
            padding: 14px 20px; border-radius: 12px;
            font-weight: bold; font-size: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            cursor: pointer; min-width: 260px;
            display: flex; align-items: center; gap: 12px;
            animation: slideIn 0.3s ease;
        `;
        toast.innerHTML = `
            <i class="fas fa-bell fa-lg"></i>
            <div>
                <div>🔔 Pesanan Baru Masuk!</div>
                <small style="opacity:0.85; font-weight:normal;">
                    Klik untuk ke halaman pesanan
                </small>
            </div>
        `;
        toast.onclick = () => {
            window.location.href = '<?= base_url('admin') ?>';
        };
        document.body.appendChild(toast);
        setTimeout(() => { if (toast) toast.remove(); }, 5000);
    }

    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { opacity:0; transform: translateX(60px); }
            to   { opacity:1; transform: translateX(0); }
        }
    `;
    document.head.appendChild(style);

    function cekPesanan() {
        fetch('<?= base_url('admin/check_count') ?>')
            .then(r => {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            })
            .then(data => {
                if (isFirstLoad) {
                    lastCount   = data.count;
                    isFirstLoad = false;
                    console.log('🔔 Notifikasi aktif. Pesanan:', lastCount);
                    return;
                }
                if (data.count > lastCount) {
                    console.log('🆕 Pesanan baru! Dari', lastCount, '→', data.count);
                    bunyikan();
                    lastCount = data.count;
                }
            })
            .catch(e => console.log('Cek pesanan gagal:', e.message));
    }

    setInterval(cekPesanan, 7000);
    cekPesanan();

    console.log('🔔 Sistem notifikasi aktif');
})();
</script>
</body>
</html>