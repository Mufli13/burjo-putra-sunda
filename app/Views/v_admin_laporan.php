<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --war-red: #ED1C24; --war-yellow: #FFD700; --war-green: #00A651; }
        body { background-color: #f4f7f6; font-family: 'Inter', sans-serif; }

        /* NAVBAR & SIDEBAR */
        .header-top { background-color: var(--war-red); height: 60px; display: flex; align-items: center; padding: 0 15px; position: sticky; top: 0; z-index: 1000; border-bottom: 4px solid var(--war-yellow); }
        .btn-hamburger { background: var(--war-red); color: white; border: 2px solid var(--war-yellow); padding: 5px 12px; border-radius: 5px; cursor: pointer; }
        .offcanvas { width: 280px !important; background: var(--war-red); color: white; border-right: 5px solid var(--war-yellow); }
        .nav-link { color: white; font-weight: bold; padding: 15px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { background: var(--war-yellow); color: var(--war-red); }

        /* CONTENT */
        .main-content { padding: 30px 20px; }
        .income-banner {
            background: linear-gradient(135deg, var(--war-green) 0%, #007a3a 100%);
            color: white; border-radius: 15px; padding: 25px; margin-bottom: 25px;
        }
        .card-report { border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); overflow: hidden; background: white; margin-bottom: 20px; }
        .table thead th { background-color: #f8f9fa; color: #444; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; padding: 12px 15px; }
        .table tbody td { padding: 12px 15px; vertical-align: middle; }
        .time-badge { background: #f0f2f5; color: #666; padding: 4px 8px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; display: inline-block; width: 70px; text-align: center; }
        .customer-name { color: #2d3436; font-weight: 700; font-size: 1rem; }
        .order-detail-text { color: #636e72; font-size: 0.9rem; font-style: italic; }
        .price-text { font-weight: 700; color: var(--war-green); font-size: 1rem; }

        /* REAL-TIME BADGE */
        .realtime-badge {
            background: rgba(0,166,81,0.1); color: var(--war-green);
            border: 1px solid var(--war-green);
            padding: 4px 12px; border-radius: 20px;
            font-size: 12px; font-weight: bold;
        }

        /* PRINT STYLE */
        @media print {
            @page { size: A4; margin: 0; }
            body { background: white !important; margin: 2cm; font-family: "Arial", sans-serif; color: black; font-size: 12pt !important; }
            .header-top, .offcanvas, .no-print, .btn-hamburger, .income-banner, .btn-logout-sidebar { display: none !important; }
            .main-content { padding: 0 !important; margin: 0 !important; }

            /* KOP SURAT MUNCUL SAAT PRINT */
            .kop-surat { display: block !important; text-align: center; margin-bottom: 20px; }
            .kop-surat h1 { margin: 0; font-weight: bold; font-size: 16pt; text-decoration: underline; text-transform: uppercase; }
            .kop-surat h2 { margin: 5px 0 0 0; font-size: 13pt; font-weight: bold; }
            .kop-surat p { margin: 5px 0 0 0; font-size: 11pt; border-bottom: 2px solid #000; padding-bottom: 10px; }

            .card-report { box-shadow: none !important; border: 1px solid #000 !important; border-radius: 0 !important; margin-bottom: 20px; }
            .table { border-collapse: collapse !important; width: 100% !important; }
            .table th, .table td { border: 1px solid #000 !important; color: black !important; padding: 10px !important; font-size: 12pt !important; }
            .badge { background: transparent !important; border: none !important; color: black !important; padding: 0 !important; font-weight: bold !important; }
            .time-badge { background: transparent !important; color: black !important; padding: 0 !important; width: auto !important; }
            .signature-section { display: flex !important; justify-content: flex-end; margin-top: 50px; }
            .print-total-row { display: table-row !important; background: #f2f2f2 !important; font-weight: bold; }
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header-top shadow-sm justify-content-between">
    <div class="d-flex align-items-center">
        <button class="btn-hamburger" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarAdmin">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="text-white ms-2 mb-0 fw-bold">
            PUTRA SUNDA <small class="text-warning d-none d-sm-inline">Laporan</small>
        </h5>
    </div>
    <div class="pe-1">
        <a href="<?= base_url('/') ?>" target="_blank"
           class="btn btn-outline-warning btn-sm fw-bold border-2 rounded-pill px-3">
            <i class="fas fa-home"></i>
            <span class="d-none d-md-inline ms-1">LIHAT MENU</span>
        </a>
    </div>
</div>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarAdmin">
    <div class="offcanvas-header border-bottom border-white border-opacity-10">
        <h5 class="offcanvas-title fw-bold text-white">MENU ADMIN</h5>
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
            <a class="nav-link active" href="<?= base_url('admin/laporan') ?>">
                <i class="fas fa-file-invoice-dollar me-2"></i> Laporan Harian
            </a>
            <a class="nav-link" href="<?= base_url('admin/ai_dashboard') ?>">
                <i class="fas fa-brain me-2"></i> Dashboard AI
            </a>
        </nav>
        <div class="mt-auto">
            <button class="btn-logout-sidebar border-0 text-white w-100 p-3"
                    style="background:rgba(0,0,0,0.2)"
                    onclick="confirmAction('<?= base_url('auth/logout') ?>')">
                <i class="fas fa-sign-out-alt me-2"></i> LOGOUT
            </button>
        </div>
    </div>
</div>

<!-- KOP SURAT — hanya muncul saat print -->
<div class="kop-surat d-none">
    <h1>LAPORAN PENJUALAN HARIAN</h1>
    <h2>BURJO & WARMINDO PUTRA SUNDA</h2>
    <p>
        Cabang Genuk, Semarang &nbsp;|&nbsp;
        Tanggal: <span id="kop-tanggal"></span> &nbsp;|&nbsp;
        Waktu: <span id="kop-waktu"></span> WIB
    </p>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container-fluid">

        <!-- JUDUL + TOMBOL -->
        <div class="d-flex justify-content-between align-items-start mb-3 no-print">
            <div>
                <h3 class="fw-bold text-dark mb-1">REKAP LAPORAN</h3>
                <!-- Tanggal dari PHP -->
                <div class="mb-1">
                    <i class="fas fa-calendar-alt text-danger me-1"></i>
                    <strong><?= $tanggal ?></strong>
                </div>
                <!-- Jam real-time dari JavaScript -->
                <span class="realtime-badge">
                    <i class="fas fa-circle text-success me-1" style="font-size:8px;"></i>
                    Live: <span id="jam-realtime">--:--:--</span> WIB
                </span>
            </div>
            <div class="d-flex gap-2 no-print">
                <!-- Tombol cetak biasa -->
                <button onclick="cetakBiasa()"
                        class="btn btn-dark fw-bold px-3 rounded-pill shadow-sm">
                    <i class="fas fa-print me-1"></i> CETAK
                </button>
                <!-- Tombol cetak + hapus data -->
                <button onclick="bukaModalReset()"
                        class="btn btn-danger fw-bold px-3 rounded-pill shadow-sm">
                    <i class="fas fa-print me-1"></i> CETAK & RESET
                </button>
            </div>
        </div>

        <!-- BANNER OMZET -->
        <div class="income-banner shadow-sm d-flex justify-content-between align-items-center no-print">
            <div>
                <p class="mb-1 fw-bold opacity-75 text-uppercase">Omzet Hari Ini</p>
                <h1 class="display-5 fw-bold mb-0">
                    Rp <?= number_format($omzet, 0, ',', '.') ?>
                </h1>
                <small class="opacity-75">Dari <?= $total_order ?> transaksi hari ini</small>
            </div>
            <div class="display-3 opacity-25 d-none d-sm-block">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>

        <!-- REKAP MENU TERJUAL -->
        <div class="card card-report">
            <div class="card-header bg-white py-3 border-bottom no-print">
                <h6 class="m-0 fw-bold text-dark">
                    <i class="fas fa-chart-pie me-2 text-success"></i>REKAP MENU TERJUAL
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4 text-start">NAMA MENU</th>
                                <th class="text-center" style="width:200px;">KUANTITAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($rekap_menu)): ?>
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                        Belum ada pesanan hari ini
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($rekap_menu as $name => $qty): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-dark text-start text-uppercase">
                                        <?= htmlspecialchars($name) ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-3 py-2">
                                            <?= $qty ?> Porsi
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- RINCIAN TRANSAKSI -->
        <div class="card card-report">
            <div class="card-header bg-white py-3 border-bottom no-print">
                <h6 class="m-0 fw-bold text-dark">
                    <i class="fas fa-list me-2 text-danger"></i>RINCIAN TRANSAKSI
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4 text-start" style="width:120px;">WAKTU</th>
                                <th class="text-start">PELANGGAN & DETAIL</th>
                                <th class="text-end pe-4" style="width:200px;">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($laporan)): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        Belum ada transaksi hari ini
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($laporan as $l): ?>
                                <tr>
                                    <td class="ps-4 text-start">
                                        <span class="time-badge">
                                            <?= date('H:i', strtotime($l['order_date'])) ?>
                                        </span>
                                    </td>
                                    <td class="text-start">
                                        <div class="customer-name text-uppercase">
                                            <?= htmlspecialchars($l['customer_name']) ?>
                                        </div>
                                        <div class="order-detail-text">
                                            <?= htmlspecialchars($l['order_details']) ?>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="price-text">
                                            Rp <?= number_format($l['total_price'], 0, ',', '.') ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>

                                <!-- Baris total — muncul saat print -->
                                <tr class="d-none print-total-row">
                                    <td colspan="2" class="text-end ps-4 py-3 fw-bold">
                                        TOTAL PENDAPATAN HARIAN :
                                    </td>
                                    <td class="text-end pe-4 py-3 fw-bold">
                                        Rp <?= number_format($omzet, 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TANDA TANGAN — muncul saat print -->
        <div class="signature-section d-none">
            <div class="text-end mt-5">
                <p>Semarang, <span id="ttd-tanggal"><?= $tanggal ?></span></p>
                <br><br><br>
                <p><strong>( ________________ )</strong><br>Admin Kasir</p>
            </div>
        </div>

    </div>
</div>

<!-- Modal SUKSES RESET -->
<div class="modal fade" id="modalSuksesReset" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius:15px;">
            <div class="modal-body p-4 text-center">
                <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                <h5 class="fw-bold text-success">Reset Berhasil!</h5>
                <p class="text-muted small mb-3">
                    Semua data transaksi hari ini telah dihapus.
                    Laporan siap untuk hari berikutnya.
                </p>
                <button class="btn btn-success w-100 fw-bold"
                        onclick="location.reload()" style="border-radius:10px;">
                    <i class="fas fa-sync-alt me-1"></i> Muat Ulang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal GAGAL RESET -->
<div class="modal fade" id="modalGagalReset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius:15px;">
            <div class="modal-body p-4 text-center">
                <i class="fas fa-times-circle text-danger fa-3x mb-3"></i>
                <h5 class="fw-bold text-danger">Reset Gagal!</h5>
                <p class="text-muted small mb-1" id="pesanGagal">
                    Terjadi kesalahan saat menghapus data.
                </p>
                <small class="text-muted">Cetak tetap berhasil, coba reset manual.</small>
                <button class="btn btn-danger w-100 fw-bold mt-3"
                        data-bs-dismiss="modal" style="border-radius:10px;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <i class="fas fa-question-circle text-warning mb-3" style="font-size:2rem;"></i>
                <h5 class="fw-bold">Logout?</h5>
                <div class="d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-light w-100 fw-bold"
                            data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="confirmBtnLink" class="btn btn-danger w-100 fw-bold">Ya</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi CETAK & RESET -->
<div class="modal fade" id="modalReset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius:15px;">
            <div class="modal-body p-4 text-center">
                <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                <h5 class="fw-bold">Cetak & Reset Data?</h5>
                <p class="text-muted small">
                    Laporan akan dicetak, lalu
                    <strong>semua data transaksi hari ini dihapus.</strong>
                    Aksi ini tidak bisa dibatalkan!
                </p>
                <div class="d-flex gap-2">
                    <button class="btn btn-light w-100 fw-bold"
                            data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-danger w-100 fw-bold"
                            onclick="konfirmasiCetakReset()">
                        Ya, Cetak!
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ============================================
// REAL-TIME JAM & KOP SURAT
// ============================================
const namaBulan = ['Januari','Februari','Maret','April','Mei','Juni',
                   'Juli','Agustus','September','Oktober','November','Desember'];

function updateWaktu() {
    const now   = new Date();
    const tgl   = String(now.getDate()).padStart(2, '0');
    const bulan = namaBulan[now.getMonth()];
    const tahun = now.getFullYear();
    const jam   = String(now.getHours()).padStart(2, '0');
    const menit = String(now.getMinutes()).padStart(2, '0');
    const detik = String(now.getSeconds()).padStart(2, '0');

    const waktuStr = `${jam}:${menit}:${detik}`;

    // Update jam real-time di layar
    const elJam = document.getElementById('jam-realtime');
    if (elJam) elJam.innerText = waktuStr;

    // Update kop surat untuk print
    const kopTgl = document.getElementById('kop-tanggal');
    const kopWkt = document.getElementById('kop-waktu');
    if (kopTgl) kopTgl.innerText = `${tgl} ${bulan} ${tahun}`;
    if (kopWkt) kopWkt.innerText = waktuStr;
}

// Update setiap detik
setInterval(updateWaktu, 1000);
updateWaktu(); // Langsung jalankan saat halaman dibuka

// ============================================
// CETAK BIASA (data tidak dihapus)
// ============================================
function cetakBiasa() {
    window.print();
}

// ============================================
// BUKA MODAL KONFIRMASI RESET
// ============================================
function bukaModalReset() {
    new bootstrap.Modal(document.getElementById('modalReset')).show();
}

// ============================================
// CETAK + HAPUS DATA HARI INI
// ============================================
function konfirmasiCetakReset() {
    const modalEl  = document.getElementById('modalReset');
    const modalObj = bootstrap.Modal.getInstance(modalEl);
    modalObj.hide();

    modalEl.addEventListener('hidden.bs.modal', function handler() {
        modalEl.removeEventListener('hidden.bs.modal', handler);

        // Bersihkan backdrop modal
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');

        // Print setelah modal benar-benar hilang
        setTimeout(() => {
            window.print();

            // Hapus data setelah print
            setTimeout(() => {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const csrfName  = document.querySelector('meta[name="csrf-name"]')?.getAttribute('content')  || 'csrf_token';

                const formData = new FormData();
                formData.append(csrfName, csrfToken);

                fetch('<?= base_url('admin/hapusLaporanHarian') ?>', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                })
                .then(res => {
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    return res.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        // ✅ Tampilkan popup sukses (bukan alert)
                        new bootstrap.Modal(
                            document.getElementById('modalSuksesReset')
                        ).show();
                    } else {
                        // ❌ Tampilkan popup gagal
                        document.getElementById('pesanGagal').innerText =
                            data.pesan || 'Error tidak diketahui';
                        new bootstrap.Modal(
                            document.getElementById('modalGagalReset')
                        ).show();
                    }
                })
                .catch(err => {
                    // ❌ Tampilkan popup gagal dengan pesan error
                    document.getElementById('pesanGagal').innerText =
                        'Koneksi error: ' + err.message;
                    new bootstrap.Modal(
                        document.getElementById('modalGagalReset')
                    ).show();
                });

            }, 2000);
        }, 100);
    });
}

// ============================================
// KONFIRMASI LOGOUT
// ============================================
function confirmAction(url) {
    document.getElementById('confirmBtnLink').setAttribute('href', url);
    new bootstrap.Modal(document.getElementById('confirmModal')).show();
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