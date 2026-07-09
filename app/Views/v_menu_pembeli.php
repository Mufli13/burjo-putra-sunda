<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --red: #ED1C24; --yellow: #FFD700; --green: #00A651; }
        body { background-color: #f4f4f4; scroll-behavior: smooth; }
        
        .header-top { background-color: var(--red); height: 50px; position: relative; }
        .btn-sidebar {
            position: absolute; left: 15px; top: 15px; background: var(--red);
            color: white; border: none; padding: 5px 10px; border-radius: 5px;
            z-index: 1100; box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .navbar-warmindo {
            background-color: var(--yellow); padding: 10px 0 30px 0;
            text-align: center; border-bottom: 8px solid var(--red); position: relative;
        }
        .navbar-warmindo h1 { color: var(--red); font-weight: 900; margin: 0; font-size: 1.8rem; }
        
        .wave {
            position: absolute; bottom: -30px; left: 0; width: 100%; height: 30px;
            background-color: var(--green); clip-path: ellipse(50% 100% at 50% 0%);
        }

        .search-container { margin-top: 50px; padding: 0 15px; }
        .search-input { border-radius: 10px; border: 2px solid var(--red); padding: 12px; font-weight: bold; }

        .offcanvas { width: 250px !important; background-color: white; border-right: 5px solid var(--red); }
        .offcanvas-header { background-color: var(--red); color: white; padding-left: 60px; }
        .sidebar-link {
            text-decoration: none; color: #333; display: block;
            padding: 12px 20px; border-bottom: 1px solid #eee; font-weight: bold;
        }
        .sidebar-link:hover { background-color: var(--yellow); color: var(--red); }

        .category-title {
            background: var(--red); color: white; padding: 5px 15px;
            border-radius: 0 20px 20px 0; margin: 30px 0 15px 0;
            display: inline-block; font-weight: bold;
        }
        .menu-card {
            background: white; border-radius: 10px; padding: 12px;
            margin-bottom: 10px; border-left: 5px solid var(--yellow);
            display: flex; justify-content: space-between; align-items: center;
        }
        .qty-controls { display: flex; align-items: center; gap: 10px; }
        .btn-qty { width: 32px; height: 32px; border-radius: 6px; border: none; font-weight: bold; color: white; }
        .btn-minus { background-color: var(--red); }
        .btn-plus { background-color: var(--green); }
        .qty-val { font-weight: bold; min-width: 15px; text-align: center; }

        /* BACK TO TOP */
        #backToTop {
            position: fixed; bottom: 100px; right: 20px; display: none;
            z-index: 99; background: var(--red); color: white;
            border: 2px solid var(--yellow); width: 45px; height: 45px;
            border-radius: 50%; cursor: pointer; font-size: 20px;
        }

        footer { margin-top: 50px; padding: 20px 0 120px 0; border-top: 1px solid #ddd; }

        @keyframes slideUp {
    from { opacity: 0; transform: translateX(-50%) translateY(20px); }
    to   { opacity: 1; transform: translateX(-50%) translateY(0); }
}
    </style>
</head>
<body>

<div class="header-top">
    <button class="btn-sidebar shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarKategori">
        <i class="fas fa-bars"></i>
    </button>
</div>

<div class="navbar-warmindo">
    <h1>PUTRA SUNDA</h1>
    <p class="mb-0 fw-bold" style="color: var(--red)">Warmindo & Burjo</p>
    <div class="wave"></div>
</div>

<div class="container search-container">
    <input type="text" id="searchInput" class="form-control search-input text-center" placeholder="🔍 Cari menu favoritmu...">
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarKategori">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold">KATEGORI MENU</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <a href="javascript:void(0)" class="sidebar-link" onclick="filterCategory('all')">Semua Menu</a>
        <a href="javascript:void(0)" class="sidebar-link" onclick="filterCategory('nasi-telur')">Aneka Nasi Telur</a>
        <a href="javascript:void(0)" class="sidebar-link" onclick="filterCategory('nasi-ayam')">Aneka Nasi Ayam</a>
        <a href="javascript:void(0)" class="sidebar-link" onclick="filterCategory('nasi-goreng')">Nasi Goreng & Magelangan</a>
        <a href="javascript:void(0)" class="sidebar-link" onclick="filterCategory('mie')">Aneka Mie</a>
        <a href="javascript:void(0)" class="sidebar-link" onclick="filterCategory('camilan')">Camilan & Toping</a>
        <a href="javascript:void(0)" class="sidebar-link" onclick="filterCategory('MINUMAN')">Minuman</a>
    </div>
</div>

<?php if(!empty($rekomendasi_ai)): ?>
<div class="container mt-3">
    <div class="p-3 bg-white border-start border-success border-4 shadow-sm" style="border-radius: 10px;">
        <h6 class="fw-bold text-success"><i class="fas fa-magic"></i> Rekomendasi Untukmu</h6>
        <small class="text-muted">Banyak pelanggan memesan menu ini bersamaan:</small>
        <div class="mt-2">
            <?php foreach($rekomendasi_ai as $ai): ?>
                <span class="badge bg-light text-dark border p-2 mb-1">
                    <?= $ai['item_awal'] ?> + <?= $ai['item_tujuan'] ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container mt-3 mb-5 pb-5" id="menu-container">
    <?php if(empty($no_meja)): ?>
        <div class="alert alert-danger text-center py-3 fw-bold shadow-sm">
            <i class="fas fa-exclamation-triangle"></i> MEJA BELUM TERDETEKSI<br>
            <small>Silakan scan ulang QR Code di meja Anda.</small>
        </div>
    <?php else: ?>
        <div class="alert alert-dark text-center py-2">Meja: <strong><?= $no_meja ?></strong></div>
    <?php endif; ?>

    <div class="menu-section" data-category="nasi-telur">
        <div class="category-title">ANEKA NASI TELUR</div>
        <?php foreach($nasi_telur as $m): ?>
        <div class="menu-card shadow-sm menu-item">
            <div><strong class="menu-name"><?= $m['name'] ?></strong><br><small>Rp <?= number_format($m['price'], 0, ',', '.') ?></small></div>
            <div class="qty-controls">
                <button class="btn-qty btn-minus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, -1, 'qty_<?= $m['id'] ?>')">-</button>
                <span class="qty-val" id="qty_<?= $m['id'] ?>">0</span>
                <button class="btn-qty btn-plus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, 1, 'qty_<?= $m['id'] ?>')">+</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="menu-section" data-category="nasi-ayam">
        <div class="category-title">ANEKA NASI AYAM</div>
        <?php foreach($nasi_ayam as $m): ?>
        <div class="menu-card shadow-sm menu-item">
            <div><strong class="menu-name"><?= $m['name'] ?></strong><br><small>Rp <?= number_format($m['price'], 0, ',', '.') ?></small></div>
            <div class="qty-controls">
                <button class="btn-qty btn-minus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, -1, 'qty_<?= $m['id'] ?>')">-</button>
                <span class="qty-val" id="qty_<?= $m['id'] ?>">0</span>
                <button class="btn-qty btn-plus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, 1, 'qty_<?= $m['id'] ?>')">+</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="menu-section" data-category="nasi-goreng">
        <div class="category-title">NASI GORENG & MAGELANGAN</div>
        <?php foreach(array_merge($nasi_goreng, $magelangan) as $m): ?>
        <div class="menu-card shadow-sm menu-item">
            <div><strong class="menu-name"><?= $m['name'] ?></strong><br><small>Rp <?= number_format($m['price'], 0, ',', '.') ?></small></div>
            <div class="qty-controls">
                <button class="btn-qty btn-minus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, -1, 'qty_<?= $m['id'] ?>')">-</button>
                <span class="qty-val" id="qty_<?= $m['id'] ?>">0</span>
                <button class="btn-qty btn-plus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, 1, 'qty_<?= $m['id'] ?>')">+</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="menu-section" data-category="mie">
        <div class="category-title">ANEKA MIE</div>
        <?php foreach($mie as $m): ?>
        <div class="menu-card shadow-sm menu-item">
            <div><strong class="menu-name"><?= $m['name'] ?></strong><br><small>Rp <?= number_format($m['price'], 0, ',', '.') ?></small></div>
            <div class="qty-controls">
                <button class="btn-qty btn-minus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, -1, 'qty_<?= $m['id'] ?>')">-</button>
                <span class="qty-val" id="qty_<?= $m['id'] ?>">0</span>
                <button class="btn-qty btn-plus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, 1, 'qty_<?= $m['id'] ?>')">+</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="menu-section" data-category="camilan">
        <div class="category-title">CAMILAN & TOPING</div>
        <?php foreach(array_merge($camilan, $toping) as $m): ?>
        <div class="menu-card shadow-sm menu-item">
            <div><strong class="menu-name"><?= $m['name'] ?></strong><br><small>Rp <?= number_format($m['price'], 0, ',', '.') ?></small></div>
            <div class="qty-controls">
                <button class="btn-qty btn-minus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, -1, 'qty_<?= $m['id'] ?>')">-</button>
                <span class="qty-val" id="qty_<?= $m['id'] ?>">0</span>
                <button class="btn-qty btn-plus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, 1, 'qty_<?= $m['id'] ?>')">+</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="menu-section" data-category="MINUMAN">
        <div class="category-title">MINUMAN</div>
        <?php foreach($minuman as $m): ?>
        <div class="menu-card shadow-sm menu-item">
            <div><strong class="menu-name"><?= $m['name'] ?></strong><br><small>Rp <?= number_format($m['price'], 0, ',', '.') ?></small></div>
            <div class="qty-controls">
                <button class="btn-qty btn-minus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, -1, 'qty_<?= $m['id'] ?>')">-</button>
                <span class="qty-val" id="qty_<?= $m['id'] ?>">0</span>
                <button class="btn-qty btn-plus" onclick="updateQty('<?= $m['name'] ?>', <?= $m['price'] ?>, 1, 'qty_<?= $m['id'] ?>')">+</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <footer class="text-center mt-5 pb-5">
        <p class="text-muted small mb-0">
            <a href="<?= base_url('auth/portal') ?>" style="text-decoration: none; color: inherit; cursor: default;">
                © 2026 Putra Sunda - Semarang
            </a>
        </p>
    </footer>
</div>

<button id="backToTop" onclick="scrollToTop()" title="Ke Atas"><i class="fas fa-chevron-up"></i></button>

<div class="fixed-bottom p-3" style="z-index: 1030;">
    <button class="btn btn-success w-100 shadow-lg py-3 fw-bold" style="border-radius: 15px; background-color: var(--green); border: 2px solid var(--yellow);" onclick="bukaModalCheckout()">
        🛒 PESAN (<span id="count">0</span>) - Rp <span id="total-bayar">0</span>
    </button>
</div>

<div class="modal fade" id="modalCheckout" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-body p-4 text-center">
                <div class="mb-3 text-success" style="font-size: 3rem;"><i class="fas fa-shopping-basket"></i></div>
                <h4 class="fw-bold">Konfirmasi Pesanan</h4>
                <p class="text-muted">Halo, silakan masukkan nama panggilan Anda untuk memudahkan panggilan pesanan.</p>
                <input type="text" id="inputNamaPelanggan" class="form-control mb-3 text-center fw-bold border-2" placeholder="Nama Anda..." style="border-radius: 10px; border-color: var(--red);">
                <div class="alert alert-light text-start small border">
                    <div id="ringkasanPesanan"></div>
                    <hr class="my-1">
                    <strong class="text-danger">Total: Rp <span id="modalTotalHarga">0</span></strong>
                </div>
                <div class="row g-2">
                    <div class="col-6"><button class="btn btn-light w-100 fw-bold py-2" data-bs-dismiss="modal">BATAL</button></div>
                    <div class="col-6"><button class="btn btn-success w-100 fw-bold py-2" onclick="prosesCheckout()">KIRIM PESANAN</button></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let cart = {}; 
    let totalHarga = 0;
    let totalCount = 0;
    let noMeja = '<?= $no_meja ?>';

// =============================================
// FUNGSI AI RECOMMENDATION (TAMBAHAN BARU)
// =============================================
async function getRekomendasi(namaMenu) {
    try {
        // Kirim nama menu ke FastAPI
        const response = await fetch('http://127.0.0.1:8000/recommend', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ menu: namaMenu })
        });

        // Kalau API tidak bisa dihubungi, diam saja (tidak error)
        if (!response.ok) return;

        const data = await response.json();

        // Tampilkan rekomendasi sebagai toast notification
        tampilkanRekomendasi(namaMenu, data.rekomendasi);

    } catch (err) {
        // Kalau FastAPI mati, web tetap jalan normal
        console.log('AI offline, skip rekomendasi');
    }
}

function tampilkanRekomendasi(menuDipilih, daftarRekomendasi) {
    // Hapus rekomendasi sebelumnya kalau masih ada
    let existing = document.getElementById('toast-rekomendasi');
    if (existing) existing.remove();

    // Buat tampilan rekomendasi
    let rekomendasiText = daftarRekomendasi.join(', ');
    let toast = document.createElement('div');
    toast.id = 'toast-rekomendasi';
    toast.style.cssText = `
        position: fixed; bottom: 90px; left: 50%; transform: translateX(-50%);
        background: white; border-left: 5px solid #00A651;
        border-radius: 12px; padding: 12px 16px; z-index: 9999;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2); width: 90%; max-width: 400px;
        animation: slideUp 0.3s ease;
    `;
    toast.innerHTML = `
        <div style="display:flex; justify-content:space-between; align-items:start;">
            <div>
                <p style="margin:0; font-weight:bold; color:#00A651; font-size:13px;">
                    ✨ Rekomendasi Untukmu
                </p>
                <p style="margin:4px 0 0 0; font-size:13px; color:#333;">
                    Cocok dengan <strong>${menuDipilih}</strong>:<br>
                    <span style="color:#ED1C24; font-weight:bold;">${rekomendasiText}</span>
                </p>
            </div>
            <button onclick="document.getElementById('toast-rekomendasi').remove()" 
                style="background:none; border:none; font-size:18px; color:#999; cursor:pointer; padding:0 0 0 10px;">✕</button>
        </div>
    `;

    document.body.appendChild(toast);

    // Hilang otomatis setelah 5 detik
    setTimeout(() => { if(toast) toast.remove(); }, 5000);
}
        
    // Back to Top Logic
    window.onscroll = function() {
        let btt = document.getElementById("backToTop");
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            btt.style.display = "block";
        } else {
            btt.style.display = "none";
        }
    };

    function scrollToTop() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function filterCategory(category) {
        const sections = document.querySelectorAll('.menu-section');
        sections.forEach(section => {
            section.style.display = (category === 'all' || section.getAttribute('data-category') === category) ? 'block' : 'none';
        });
        const offcanvasElement = document.getElementById('sidebarKategori');
        const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
        if(bsOffcanvas) bsOffcanvas.hide();
        window.scrollTo(0, 0);
    }

    function updateQty(nama, harga, change, elementId) {
    let qtyElement = document.getElementById(elementId);
    let currentQty = parseInt(qtyElement.innerText);
    let newQty = currentQty + change;
    if (newQty < 0) return;

    qtyElement.innerText = newQty;
    if (newQty === 0) delete cart[nama];
    else cart[nama] = { harga, qty: newQty };

    calculateTotal();

    // TAMBAHAN BARU: Panggil AI hanya saat tambah (bukan kurang)
    if (change > 0) {
        getRekomendasi(nama);
    }
}

    function calculateTotal() {
        totalHarga = 0; totalCount = 0;
        for (let item in cart) {
            totalHarga += cart[item].harga * cart[item].qty;
            totalCount += cart[item].qty;
        }
        document.getElementById('count').innerText = totalCount;
        document.getElementById('total-bayar').innerText = totalHarga.toLocaleString('id-ID');
    }

    function bukaModalCheckout() {
    // 1. CEK MEJA (PAKAI MODAL)
    if (!noMeja || noMeja == '0' || noMeja.trim() === "") {
        let modalMeja = new bootstrap.Modal(document.getElementById('modalGagalMeja'));
        modalMeja.show();
        return; 
    }

    // 2. CEK MENU KOSONG (PAKAI MODAL)
    if (totalCount === 0) {
        let modalMenu = new bootstrap.Modal(document.getElementById('modalPilihMenu'));
        modalMenu.show();
        return;
    }

    // 3. JIKA SEMUA OK, TAMPILKAN KONFIRMASI PESANAN
    let ringkasanTeks = Object.keys(cart).map(k => `${cart[k].qty}x ${k}`).join("<br>");
    document.getElementById('ringkasanPesanan').innerHTML = ringkasanTeks;
    document.getElementById('modalTotalHarga').innerText = totalHarga.toLocaleString('id-ID');
    
    let myModal = new bootstrap.Modal(document.getElementById('modalCheckout'));
    myModal.show();
}

   function prosesCheckout() {
    let namaInput = document.getElementById('inputNamaPelanggan');
    let nama = namaInput.value;
    
    // 1. Validasi Nama pakai Modal Nama Kosong
    if (!nama || nama.trim() === "") {
        let modalNama = new bootstrap.Modal(document.getElementById('modalNamaKosong'));
        modalNama.show();
        return;
    }

    const btnKirim = document.querySelector('#modalCheckout button.btn-success');
    const modalElement = document.getElementById('modalCheckout');
    const bsModalCheckout = bootstrap.Modal.getInstance(modalElement);

    // Kunci tombol biar gak double klik
    btnKirim.disabled = true;
    btnKirim.innerHTML = '<i class="fas fa-spinner fa-spin"></i> MENGIRIM...';

    let rincian = Object.keys(cart).map(k => `${cart[k].qty}x ${k}`).join(", ");
    let formData = new FormData();
    formData.append('nama', nama);
    formData.append('total', totalHarga);
    formData.append('no_meja', noMeja);
    formData.append('pesanan', rincian);

    // 2. Kirim ke Controller
    fetch('<?= base_url('home/checkout') ?>', { method: 'POST', body: formData })
    .then(res => res.json()) 
    .then(data => {
        if(data.status === 'success') {
    // ✅ KIRIM DATA KE AI UNTUK BELAJAR
    const menuList = Object.keys(cart);
    fetch('http://127.0.0.1:8000/learn', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ items: menuList })
    }).catch(() => console.log('AI learn offline, skip'));
    // ✅ SELESAI KIRIM DATA AI

    // TUTUP modal input nama
    if(bsModalCheckout) bsModalCheckout.hide();
            
            // TAMPILKAN modal sukses (Centang Hijau)
            // Halaman GAK AKAN REFRESH sampai tombol di modal ini diklik
            let modalSukses = new bootstrap.Modal(document.getElementById('modalSukses'));
            modalSukses.show();
            
        } else {
            alert("Gagal: " + data.message);
            btnKirim.disabled = false;
            btnKirim.innerText = 'KIRIM PESANAN';
        }
    })
    .catch(err => {
        console.error(err);
        alert("Terjadi gangguan koneksi, tapi cek kasir ya mungkin pesanan sudah masuk.");
        btnKirim.disabled = false;
        btnKirim.innerText = 'KIRIM PESANAN';
    });
}

// 3. Fungsi ini yang bikin halaman refresh SETELAH klik "TERIMA KASIH"
function selesaiPesan() {
    location.reload(); // Refresh hanya setelah tombol diklik
}

    // --- PENCARIAN ---
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let keyword = this.value.toLowerCase();
        let sections = document.querySelectorAll('.menu-section');
        sections.forEach(section => {
            let items = section.querySelectorAll('.menu-item');
            let hasVisibleItem = false;
            items.forEach(item => {
                let name = item.querySelector('.menu-name').innerText.toLowerCase();
                if (name.includes(keyword)) {
                    item.style.setProperty('display', 'flex', 'important');
                    hasVisibleItem = true;
                } else {
                    item.style.setProperty('display', 'none', 'important');
                }
            });
            section.style.display = (hasVisibleItem || keyword === "") ? 'block' : 'none';
        });
    });
</script>
<div class="modal fade" id="modalGagalMeja" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-body p-4 text-center">
                <div class="mb-3 text-danger" style="font-size: 4rem;"><i class="fas fa-qrcode"></i></div>
                <h4 class="fw-bold text-danger">AKSES DITOLAK!</h4>
                <p class="text-muted">Nomor meja tidak ditemukan. Silakan scan QR Code di meja untuk memesan.</p>
                <button type="button" class="btn btn-danger w-100 fw-bold py-2" data-bs-dismiss="modal">OKE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPilihMenu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-body p-4 text-center">
                <div class="mb-3 text-warning" style="font-size: 3rem;"><i class="fas fa-utensils"></i></div>
                <h5 class="fw-bold">Menu Kosong</h5>
                <p class="text-muted small">Pilih menu dulu sebelum pesan ya!</p>
                <button type="button" class="btn btn-warning w-100 fw-bold" data-bs-dismiss="modal">SIAP!</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSukses" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-body p-4 text-center">
                <div class="mb-3 text-success" style="font-size: 4rem;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h4 class="fw-bold text-success">PESANAN TERKIRIM!</h4>
                <p class="text-muted">Pesananmu sudah masuk ke dapur. Mohon tunggu panggilan dari kasir ya!</p>
                <button type="button" class="btn btn-success w-100 fw-bold py-2" onclick="selesaiPesan()" style="border-radius: 10px;">SIAP, TERIMA KASIH!</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalNamaKosong" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-body p-4 text-center">
                <div class="mb-3 text-danger" style="font-size: 3rem;"><i class="fas fa-user-edit"></i></div>
                <h5 class="fw-bold">Nama Belum Diisi</h5>
                <p class="text-muted small">Tulis nama panggilanmu dulu ya, biar nanti kasir gampang panggilnya!</p>
                <button type="button" class="btn btn-danger w-100 fw-bold" data-bs-dismiss="modal">OKE</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>