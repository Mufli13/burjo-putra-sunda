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
        body { background-color: #f8f9fa; overflow-x: hidden; }
        
        /* NAVBAR RESPONSIF */
        .header-top { 
            background-color: var(--war-red); 
            height: 60px; display: flex; align-items: center; padding: 0 15px;
            position: sticky; top: 0; z-index: 1000; border-bottom: 4px solid var(--war-yellow);
        }

        .btn-hamburger { background: var(--war-red); color: white; border: 2px solid var(--war-yellow); padding: 5px 12px; border-radius: 5px; cursor: pointer; }
        .offcanvas { width: 280px !important; background: var(--war-red); color: white; border-right: 5px solid var(--war-yellow); }
        .nav-link { color: white; font-weight: bold; padding: 15px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { background: var(--war-yellow); color: var(--war-red); }

        .btn-logout-sidebar { background: rgba(0,0,0,0.2); color: white; text-align: center; padding: 15px; text-decoration: none; display: block; font-weight: bold; cursor: pointer; border: none; width: 100%; }
        .btn-logout-sidebar:hover { background: white; color: var(--war-red); }

        .main-content { padding: 20px 10px; }
        .card-header-custom { background: var(--war-red); color: white; font-weight: bold; }
        
        /* TULISAN BUTTON JADI IKON DI HP */
        .btn-status-text { font-size: 0.7rem; font-weight: 800; min-width: 40px; }
        .btn-add-menu { background-color: var(--war-green); color: white; font-weight: bold; border-radius: 8px; transition: 0.3s; border: none; }
        .btn-add-menu:hover { background-color: #00813e; color: white; transform: translateY(-2px); }

        /* Animasi Alert */
        .fade-out { transition: opacity 1s ease-out; opacity: 0; }

        /* Responsivitas Tabel */
        @media (max-width: 576px) {
            .main-content { padding: 15px 5px; }
            .h3-title { font-size: 1.2rem; }
            .hide-on-mobile { display: none; } /* Sembunyikan kolom kategori di HP agar lega */
            .btn-status-text { padding: 5px 8px; }
            .table th, .table td { font-size: 0.85rem; padding: 8px 4px !important; }
        }
    </style>
</head>
<body>

<div class="header-top shadow-sm justify-content-between">
    <div class="d-flex align-items-center">
        <button class="btn-hamburger" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarAdmin">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="text-white ms-2 mb-0 fw-bold">
            PUTRA SUNDA <small class="text-warning d-none d-sm-inline">Admin</small>
        </h5>
    </div>
    <div class="pe-1">
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
            <a class="nav-link" href="<?= base_url('admin') ?>"><i class="fas fa-shopping-cart"></i> Pesanan Masuk</a>
            <a class="nav-link active" href="<?= base_url('admin/menu') ?>"><i class="fas fa-utensils"></i> Manajemen Menu</a>
            <a class="nav-link" href="<?= base_url('admin/laporan') ?>"><i class="fas fa-file-invoice-dollar"></i> Laporan Harian</a>
            <a class="nav-link" href="<?= base_url('admin/ai_dashboard') ?>">
    <i class="fas fa-brain me-2"></i> Dashboard AI
</a>
        </nav>
        <div class="mt-auto">
            <button class="btn-logout-sidebar" onclick="confirmAction('<?= base_url('auth/logout') ?>', 'Yakin ingin logout?')">
                <i class="fas fa-sign-out-alt me-2"></i> LOGOUT
            </button>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-md-6 mb-3 mb-md-0 text-center text-md-start">
                <h3 class="fw-bold text-danger m-0 h3-title">MANAJEMEN MENU</h3>
                <p class="text-muted small mb-0">Atur stok dan daftar harga menu</p>
            </div>
            <div class="col-12 col-md-6">
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-md-end">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari menu...">
                    </div>
                    <button class="btn btn-add-menu shadow-sm px-4 py-2" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus-circle me-1"></i> TAMBAH
                    </button>
                </div>
            </div>
        </div>

        <?php if(session()->getFlashdata('message')): ?>
            <div id="info-alert" class="alert alert-success border-0 shadow-sm mb-3">
                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-header card-header-custom py-3 text-center text-md-start">
                <i class="fas fa-list me-2"></i>DAFTAR MENU AKTIF
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="menuTable">
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th class="ps-3">NAMA</th>
                                <th class="hide-on-mobile">KATEGORI</th>
                                <th>HARGA</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($menu as $m): ?>
                            <tr class="menu-row align-middle">
                                <td class="fw-bold menu-name ps-3 text-dark"><?= $m['name'] ?></td>
                                <td class="menu-cat hide-on-mobile">
                                    <span class="badge bg-light text-dark border fw-normal"><?= strtoupper($m['sub_category']) ?></span>
                                </td>
                                <td class="fw-bold text-success">Rp <?= number_format($m['price'], 0, ',', '.') ?></td>
                                <td class="text-center">
                                    <?php if($m['status'] == 'tersedia'): ?>
                                        <span class="badge bg-success px-2">ADA</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger px-2">HABIS</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        <?php if($m['status'] == 'tersedia'): ?>
                                            <button onclick="confirmAction('<?= base_url('admin/update_status/'.$m['id'].'/habis') ?>', 'Set HABIS?')" class="btn btn-sm btn-warning text-white"><i class="fas fa-times"></i></button>
                                        <?php else: ?>
                                            <button onclick="confirmAction('<?= base_url('admin/update_status/'.$m['id'].'/tersedia') ?>', 'Set ADA?')" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                        <?php endif; ?>

                                        <button class="btn btn-sm btn-outline-primary" onclick="openEditModal('<?= $m['id'] ?>', '<?= $m['name'] ?>', '<?= $m['price'] ?>', '<?= $m['sub_category'] ?>')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <button class="btn btn-sm btn-outline-danger" onclick="confirmAction('<?= base_url('admin/delete_menu/'.$m['id']) ?>', 'Hapus <?= $m['name'] ?>?')">
                                            <i class="fas fa-trash-alt"></i>
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
                <h5 class="fw-bold" id="confirmTitle">Konfirmasi</h5>
                <p class="text-muted small" id="confirmMessage"></p>
                <div class="d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-light w-100 fw-bold" data-bs-dismiss="modal">BATAL</button>
                    <a href="#" id="confirmBtnLink" class="btn btn-danger w-100 fw-bold">YA</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= base_url('admin/add_menu') ?>" method="post" class="modal-content border-0 shadow">
            <?= csrf_field() ?>
            <div class="modal-header bg-success text-white border-0 py-3">
                <h5 class="modal-title fw-bold">Tambah Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold small">Nama Menu</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Kategori</label>
                    <select name="sub_category" class="form-select" required>
                        <option value="ANEKA NASI TELUR">ANEKA NASI TELUR</option>
                        <option value="ANEKA NASI AYAM">ANEKA NASI AYAM</option>
                        <option value="NASI GORENG">NASI GORENG</option>
                        <option value="NASI MAGELANGAN">NASI MAGELANGAN</option>
                        <option value="ANEKA MIE">ANEKA MIE</option>
                        <option value="CAMILAN">CAMILAN & TOPING</option>
                        <option value="MINUMAN">MINUMAN</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="submit" class="btn btn-success fw-bold w-100 py-2">SIMPAN</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= base_url('admin/update_menu') ?>" method="post" class="modal-content border-0 shadow">
            <?= csrf_field() ?>
            <div class="modal-header bg-danger text-white border-0 py-3">
                <h5 class="modal-title fw-bold">Edit Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id" id="edit_id">
                <div class="mb-3">
                    <label class="form-label fw-bold small">Nama Menu</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Harga</label>
                    <input type="number" name="price" id="edit_price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Kategori</label>
                    <select name="sub_category" id="edit_category" class="form-select" required>
                        <option value="ANEKA NASI TELUR">ANEKA NASI TELUR</option>
                        <option value="ANEKA NASI AYAM">ANEKA NASI AYAM</option>
                        <option value="NASI GORENG">NASI GORENG</option>
                        <option value="NASI MAGELANGAN">NASI MAGELANGAN</option>
                        <option value="ANEKA MIE">ANEKA MIE</option>
                        <option value="CAMILAN">CAMILAN & TOPING</option>
                        <option value="MINUMAN">MINUMAN</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="submit" class="btn btn-success fw-bold w-100 py-2">SIMPAN PERUBAHAN</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmAction(url, message) {
        document.getElementById('confirmMessage').innerText = message;
        document.getElementById('confirmBtnLink').setAttribute('href', url);
        new bootstrap.Modal(document.getElementById('confirmModal')).show();
    }

    // AUTO HILANG ALERT (3 DETIK)
    window.setTimeout(function() {
        let alert = document.getElementById('info-alert');
        if (alert) {
            alert.classList.add('fade-out');
            setTimeout(function() { alert.remove(); }, 1000);
        }
    }, 3000);

    function openEditModal(id, name, price, category) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_category').value = category;
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    document.getElementById('searchInput').addEventListener('keyup', function() {
        let keyword = this.value.toLowerCase();
        let rows = document.querySelectorAll('.menu-row');
        rows.forEach(row => {
            let name = row.querySelector('.menu-name').innerText.toLowerCase();
            let category = row.querySelector('.menu-cat').innerText.toLowerCase();
            row.style.display = (name.includes(keyword) || category.includes(keyword)) ? "" : "none";
        });
    });
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