// ============================================================
// FILE: notif-admin.js
// FUNGSI: Notifikasi pesanan baru di semua halaman admin
// ============================================================

(function () {
  let lastOrderCount = 0;
  let isSoundActive = true;
  let hasInteracted = false;
  let isInitialLoad = true;

  // ── Buat elemen audio dinamis ──────────────────────────
  const sound = document.createElement("audio");
  sound.preload = "auto";
  sound.innerHTML = `
        <source src="/Burjo_Putra_Sunda/public/sounds/notif.mp3" type="audio/mpeg">
        <source src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" type="audio/mpeg">
    `;
  document.body.appendChild(sound);

  // ── Unlock audio saat user pertama kali klik ───────────
  document.addEventListener(
    "click",
    function () {
      if (!hasInteracted) {
        hasInteracted = true;
        sound.volume = 0;
        sound
          .play()
          .then(() => {
            sound.pause();
            sound.currentTime = 0;
            sound.volume = 1;
          })
          .catch(() => {});
      }
    },
    { once: true },
  );

  // ── Fungsi bunyikan notifikasi ─────────────────────────
  function playNotif() {
    if (!isSoundActive) return;
    sound.currentTime = 0;
    sound.volume = 1;
    sound.play().catch(() => {
      tampilToast("🔔 Pesanan baru masuk!", "danger");
    });
  }

  // ── Toast notification visual ──────────────────────────
  function tampilToast(pesan, type) {
    // Hapus toast lama
    const old = document.getElementById("global-toast-notif");
    if (old) old.remove();

    const warna = type === "danger" ? "#ED1C24" : "#00A651";
    const toast = document.createElement("div");
    toast.id = "global-toast-notif";
    toast.style.cssText = `
            position: fixed;
            top: 70px;
            right: 20px;
            z-index: 99999;
            background: ${warna};
            color: white;
            padding: 14px 20px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.25);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInRight 0.3s ease;
            cursor: pointer;
            min-width: 250px;
        `;
    toast.innerHTML = `
            <i class="fas fa-bell"></i>
            <div>
                <div>${pesan}</div>
                <small style="opacity:0.85; font-weight:normal;">
                    Klik untuk ke halaman pesanan
                </small>
            </div>
        `;

    // Klik toast → ke halaman pesanan
    toast.onclick = () => {
      window.location.href = "/Burjo_Putra_Sunda/public/admin";
    };

    document.body.appendChild(toast);

    // Hilang otomatis 5 detik
    setTimeout(() => {
      if (toast) toast.remove();
    }, 5000);
  }

  // ── Cek pesanan baru setiap 7 detik ───────────────────
  function checkNewOrders() {
    fetch("/Burjo_Putra_Sunda/public/admin/check_count")
      .then((res) => {
        if (!res.ok) throw new Error("Endpoint error");
        return res.json();
      })
      .then((data) => {
        if (isInitialLoad) {
          lastOrderCount = data.count;
          isInitialLoad = false;
          return;
        }

        if (data.count > lastOrderCount) {
          // Ada pesanan baru!
          playNotif();
          tampilToast("🔔 Pesanan baru masuk!", "danger");
          lastOrderCount = data.count;
        }
      })
      .catch((err) => {
        console.log("Notif check error:", err.message);
      });
  }

  // ── Tambah CSS animasi ─────────────────────────────────
  const style = document.createElement("style");
  style.textContent = `
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to   { opacity: 1; transform: translateX(0); }
        }
    `;
  document.head.appendChild(style);

  // ── Mulai polling ──────────────────────────────────────
  setInterval(checkNewOrders, 7000);
  checkNewOrders(); // Langsung cek pertama kali
})();
