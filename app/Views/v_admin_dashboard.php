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
        body { background-color: #f8f9fa; }
        
        .header-top { 
            background-color: var(--war-red); 
            height: 60px; display: flex; align-items: center; 
            padding: 0 15px; position: sticky; top: 0; z-index: 1000; 
            border-bottom: 4px solid var(--war-yellow); 
        }

        .btn-hamburger { background: var(--war-red); color: white; border: 2px solid var(--war-yellow); padding: 5px 12px; border-radius: 5px; cursor: pointer; }
        .offcanvas { width: 280px !important; background: var(--war-red); color: white; border-right: 5px solid var(--war-yellow); }
        .nav-link { color: white; font-weight: bold; padding: 15px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); text-decoration: none; display: block; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: var(--war-yellow); color: var(--war-red); }
        
        .btn-logout-sidebar { background: rgba(0,0,0,0.2); color: white; text-align: center; padding: 15px; text-decoration: none; display: block; font-weight: bold; transition: 0.3s; margin-top: auto; border: none; width: 100%; }
        .btn-logout-sidebar:hover { background: white; color: var(--war-red); }
        
        .main-content { padding: 20px; }
        .card-header-custom { background: var(--war-yellow); color: var(--war-red); font-weight: bold; border-bottom: 3px solid var(--war-green); }

        .btn-action { border-radius: 8px; transition: 0.3s; font-weight: 600; }
        .btn-action:hover { transform: translateY(-2px); }
        
        .fade-out { transition: opacity 1s ease-out; opacity: 0; }

        @media print {
            body * { visibility: hidden; }
            #printArea, #printArea * { visibility: visible; }
            #printArea { position: fixed; left: 2mm; top: 5mm !important; width: 54mm !important; padding: 4mm !important; border: 1px dashed #000 !important; font-size: 9pt; background-color: white !important; }
            @page { size: 58mm auto !important; margin: 0 !important; }
        }
        #printArea { font-family: 'Courier New', Courier, monospace; color: #000; }
    </style>
</head>
<body>

<div class="header-top shadow-sm justify-content-between">
    <div class="d-flex align-items-center">
        <button class="btn-hamburger" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarAdmin">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="text-white ms-3 mb-0 fw-bold">PUTRA SUNDA <small class="text-warning d-none d-sm-inline">Dapoer</small></h5>
    </div>
    <div class="pe-2">
        <a href="<?= base_url('/') ?>" target="_blank" class="btn btn-outline-warning btn-sm fw-bold border-2 rounded-pill px-3">
            <i class="fas fa-home"></i> 
            <span class="d-none d-md-inline ms-1">LIHAT MENU</span>
        </a>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarAdmin">
    <div class="offcanvas-header border-bottom border-light border-opacity-10">
        <h5 class="offcanvas-title fw-bold text-white"><i class="fas fa-user-shield me-2"></i> MENU ADMIN</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0 d-flex flex-column">
        <nav class="nav flex-column">
            <a class="nav-link active" href="<?= base_url('admin') ?>"><i class="fas fa-shopping-cart"></i> Pesanan Masuk</a>
            <a class="nav-link" href="<?= base_url('admin/menu') ?>"><i class="fas fa-utensils"></i> Manajemen Menu</a>
            <a class="nav-link" href="<?= base_url('admin/laporan') ?>"><i class="fas fa-file-invoice-dollar"></i> Laporan Harian</a>
            <a class="nav-link" href="<?= base_url('admin/ai_dashboard') ?>">
    <i class="fas fa-brain me-2"></i> Dashboard AI
</a>
        </nav>
        <div class="mt-auto">
            <button class="btn-logout-sidebar" onclick="confirmPopup('<?= base_url('auth/logout') ?>', 'Yakin ingin logout?')">
                <i class="fas fa-sign-out-alt me-2"></i> LOGOUT
            </button>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="container-fluid">
        
        <?php if(session()->getFlashdata('message')): ?>
            <div id="info-alert" class="alert alert-success border-0 shadow-sm mb-4">
                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-header card-header-custom d-flex justify-content-between align-items-center py-3">
                <span><i class="fas fa-desktop me-2"></i> MONITOR PESANAN DAPUR</span>
                <div class="d-flex align-items-center">
                    <button class="btn btn-sm btn-dark fw-bold rounded-pill px-3 me-2" onclick="playNotification()">
                        <i class="fas fa-bell"></i>
                    </button>
                    <button id="btnToggleSound" class="btn btn-sm btn-light fw-bold rounded-pill px-3 me-2" onclick="toggleSound()">
                        <i id="soundIcon" class="fas fa-volume-up"></i>
                    </button>
                    <button class="btn btn-sm btn-success fw-bold rounded-pill px-3" onclick="location.reload()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3 small">Waktu</th>
                                <th>Meja</th>
                                <th>Pelanggan & Pesanan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($orders as $o): ?>
                            <tr>
                                <td class="ps-3 text-muted small"><?= date('H:i', strtotime($o['order_date'])) ?> WIB</td>
                                <td><span class="badge bg-danger p-2 px-3 rounded-pill">MEJA <?= $o['table_number'] ?></span></td>
                                <td>
                                    <div class="fw-bold text-uppercase small"><?= $o['customer_name'] ?></div>
                                    <div class="small text-muted italic" style="font-size: 0.8rem;"><?= $o['order_details'] ?></div>
                                </td>
                                <td class="fw-bold text-success small">Rp <?= number_format($o['total_price'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if($o['status'] == 'pending'): ?>
                                        <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">MENUNGGU</span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-white" style="font-size: 0.7rem;">DIMASAK</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <?php if($o['status'] == 'pending'): ?>
                                            <button onclick="confirmPopup('<?= base_url('admin/updateStatus/'.$o['id'].'/proses') ?>', 'Mulai masak pesanan meja <?= $o['table_number'] ?>?')" class="btn btn-sm btn-primary btn-action"><i class="fas fa-play"></i></button>
                                        <?php else: ?>
                                            <button onclick="confirmPopup('<?= base_url('admin/updateStatus/'.$o['id'].'/selesai') ?>', 'Selesaikan pesanan meja <?= $o['table_number'] ?>?')" class="btn btn-sm btn-success btn-action"><i class="fas fa-check"></i></button>
                                        <?php endif; ?>
                                        
                                        <button class="btn btn-sm btn-outline-dark btn-action ms-1" onclick="showDetail('<?= $o['customer_name'] ?>', '<?= $o['table_number'] ?>', '<?= $o['total_price'] ?>', '<?= addslashes($o['order_details']) ?>')">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <i class="fas fa-question-circle text-warning mb-3" style="font-size: 3rem;"></i>
                <h5 class="fw-bold">Konfirmasi</h5>
                <p class="text-muted small" id="confirmMsg"></p>
                <div class="d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-light w-100 fw-bold" data-bs-dismiss="modal">BATAL</button>
                    <a href="#" id="confirmLink" class="btn btn-danger w-100 fw-bold">YA, LANJUT</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div id="printArea" class="modal-body p-4">
                <div class="text-center mb-1">
                    <h6 class="fw-bold mb-0" style="font-size: 12pt;">PUTRA SUNDA</h6>
                    <small>Dapoer Warmindo & Burjo</small><br>
                    <small>Genuk, Semarang</small>
                </div>
                <div style="border-top: 1px dashed #000; margin: 8px 0;"></div>
                <div class="small">
                    <div class="d-flex justify-content-between"><span>Meja:</span><span id="detMeja" class="fw-bold"></span></div>
                    <div class="d-flex justify-content-between"><span>Nama :</span><span id="detNama"></span></div>
                    <div class="d-flex justify-content-between"><span>Waktu:</span><span><?= date('d/m/y H:i') ?></span></div>
                </div>
                <div style="border-top: 1px dashed #000; margin: 8px 0;"></div>
                <div id="detPesanan" style="font-size: 9pt; white-space: pre-line; margin-bottom: 5px;"></div>
                <div style="border-top: 1px dashed #000; margin: 8px 0;"></div>
                <div class="d-flex justify-content-between fw-bold" style="font-size: 10pt;">
                    <span>TOTAL:</span><span id="detTotal"></span>
                </div>
                <div style="border-top: 1px dashed #000; margin: 8px 0;"></div>
                <div class="text-center mt-3" style="font-size: 8pt;">
                    --- TERIMA KASIH ---<br>
                    Selamat Menikmati!
                </div>
            </div>
            <div class="modal-footer border-0 p-3">
                <button type="button" class="btn btn-dark w-100 fw-bold" onclick="window.print()">
                    <i class="fas fa-print me-2"></i> CETAK
                </button>
            </div>
        </div>
    </div>
</div>

<audio id="notifSound" preload="auto">
    <source src="<?= base_url('sounds/notif.mp3') ?>" type="audio/mpeg">
</audio>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let lastOrderCount = 0; 
    let isSoundActive = true;
    let hasInteracted = false;
    let isInitialLoad = true; 

    function confirmPopup(url, message) {
        document.getElementById('confirmMsg').innerText = message;
        document.getElementById('confirmLink').setAttribute('href', url);
        new bootstrap.Modal(document.getElementById('confirmModal')).show();
    }

    // AUTO HILANG 3 DETIK
    window.setTimeout(function() {
        let alert = document.getElementById('info-alert');
        if (alert) {
            alert.classList.add('fade-out');
            setTimeout(function() { alert.remove(); }, 1000);
        }
    }, 3000);

    document.addEventListener('click', function() {
        if(!hasInteracted) {
            hasInteracted = true;
            let sound = document.getElementById('notifSound');
            sound.muted = true;
            sound.play().then(() => {
                sound.pause();
                sound.muted = false;
            });
        }
    }, { once: true });

    function toggleSound() {
        isSoundActive = !isSoundActive;
        const icon = document.getElementById('soundIcon');
        const btn = document.getElementById('btnToggleSound');
        if(isSoundActive) {
            icon.className = 'fas fa-volume-up';
            btn.className = 'btn btn-sm btn-light fw-bold rounded-pill px-3 me-2';
        } else {
            icon.className = 'fas fa-volume-mute';
            btn.className = 'btn btn-sm btn-secondary fw-bold rounded-pill px-3 me-2';
        }
    }

    function playNotification() {
        if (isSoundActive) {
            let sound = document.getElementById('notifSound');
            sound.currentTime = 0;
            sound.play().catch(error => { console.log("Audio diblokir"); });
        }
    }

    function checkNewOrders() {
        fetch('<?= base_url('admin/check_count') ?>')
            .then(res => res.json())
            .then(data => {
                if (isInitialLoad) {
                    lastOrderCount = data.count;
                    isInitialLoad = false;
                    return;
                }
                if (data.count > lastOrderCount) {
                    playNotification();
                    lastOrderCount = data.count;
                    setTimeout(() => { location.reload(); }, 3000);
                }
            });
    }

    function showDetail(nama, meja, total, pesanan) {
        document.getElementById('detNama').innerText = nama.toUpperCase();
        document.getElementById('detMeja').innerText = meja;
        document.getElementById('detTotal').innerText = 'Rp ' + parseInt(total).toLocaleString('id-ID');
        document.getElementById('detPesanan').innerText = pesanan;
        new bootstrap.Modal(document.getElementById('modalDetail')).show();
    }

    setInterval(checkNewOrders, 7000);
    checkNewOrders();
</script>
</body>
</html>