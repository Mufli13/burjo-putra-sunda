# ============================================================
# FILE: main.py
# FUNGSI: AI Recommendation yang belajar dari data pembeli
# METODE: Collaborative Filtering (Co-occurrence)
# ============================================================

from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from typing import List
from collections import defaultdict
import sqlite3
import json
from database import init_db, simpan_pesanan, ambil_semua_pesanan, hitung_statistik

app = FastAPI(title="Burjo AI Recommendation", version="2.0.0")

# CORS - izinkan request dari web PHP
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Inisialisasi database saat server pertama jalan
init_db()

# ============================================================
# RULE-BASED sebagai FALLBACK (kalau data belum cukup)
# ============================================================
RULES_FALLBACK = {

    # ── ANEKA NASI TELUR ──────────────────────────────────────
    "nasi telur ceplok":        ["kerupuk kaleng", "es teh manis", "teh hangat"],
    "nasi telur balado":        ["es teh manis", "kerupuk kaleng", "teh hangat"],
    "nasi orak arik telur":     ["es teh manis", "kerupuk kaleng", "gorengan (isi 3)"],
    "nasi orak arik ayam":      ["es teh manis", "kerupuk kaleng", "teh hangat"],
    "nasi orak arik jamur":     ["teh hangat", "es teh manis", "kerupuk kaleng"],

    # ── ANEKA NASI AYAM ───────────────────────────────────────
    "nasi ayam goreng":         ["es teh manis", "kerupuk kaleng", "es jeruk segar"],
    "nasi ayam bakar":          ["es teh manis", "teh hangat", "kerupuk kaleng"],
    "nasi ayam geprek":         ["es teh manis", "es jeruk segar", "kerupuk kaleng"],
    "nasi ayam penyet":         ["es teh manis", "es jeruk segar", "kerupuk kaleng"],
    "nasi ayam rica-rica":      ["es teh manis", "es jeruk segar", "mendoan hangat (isi 3)"],
    "nasi ayam bali":           ["es teh manis", "kerupuk kaleng", "teh hangat"],

    # ── NASI GORENG & MAGELANGAN ──────────────────────────────
    "nasi goreng biasa":        ["kerupuk kaleng", "es teh manis", "gorengan (isi 3)"],
    "nasi goreng spesial (telur)": ["es teh manis", "kerupuk kaleng", "es jeruk segar"],
    "nasi goreng mawut":        ["es teh manis", "kerupuk kaleng", "teh hangat"],
    "nasi goreng sosis":        ["es teh manis", "kerupuk kaleng", "es jeruk segar"],
    "magelangan biasa":         ["es teh manis", "kerupuk kaleng", "gorengan (isi 3)"],
    "magelangan spesial":       ["es teh manis", "kerupuk kaleng", "es jeruk segar"],

    # ── ANEKA MIE ─────────────────────────────────────────────
    "indomie goreng tante (tanpa telur)": ["es teh manis", "kerupuk kaleng", "gorengan (isi 3)"],
    "indomie goreng telur":     ["es teh manis", "kerupuk kaleng", "mendoan hangat (isi 3)"],
    "indomie rebus telur":      ["es teh manis", "teh hangat", "kerupuk kaleng"],
    "indomie dok-dok":          ["es teh manis", "es jeruk segar", "kerupuk kaleng"],
    "indomie goreng double telur": ["es teh manis", "es jeruk segar", "kerupuk kaleng"],
    "indomie rebus double telur":  ["teh hangat", "es teh manis", "kerupuk kaleng"],
    "internet (indomie telur kornet)": ["es teh manis", "es jeruk segar", "kerupuk kaleng"],

    # ── CAMILAN & TOPING ──────────────────────────────────────
    "gorengan (isi 3)":         ["es teh manis", "kopi hitam kapal api", "teh hangat"],
    "roti bakar coklat keju":   ["kopi susu abc", "teh hangat", "es milo"],
    "pisang goreng keju":       ["kopi susu abc", "es teh manis", "teh hangat"],
    "kentang goreng":           ["es teh manis", "es jeruk segar", "kopi susu abc"],
    "mendoan hangat (isi 3)":   ["kopi hitam kapal api", "teh hangat", "es teh manis"],
    "kerupuk kaleng":           ["es teh manis", "teh hangat"],

    # ── MINUMAN ───────────────────────────────────────────────
    "es teh manis":             ["kerupuk kaleng", "gorengan (isi 3)", "mendoan hangat (isi 3)"],
    "es jeruk segar":           ["gorengan (isi 3)", "kerupuk kaleng", "mendoan hangat (isi 3)"],
    "es chocolate":             ["roti bakar coklat keju", "pisang goreng keju"],
    "es susu putih/coklat":     ["roti bakar coklat keju", "pisang goreng keju"],
    "es sirup marjan":          ["gorengan (isi 3)", "kerupuk kaleng"],
    "kopi hitam kapal api":     ["roti bakar coklat keju", "gorengan (isi 3)", "mendoan hangat (isi 3)"],
    "kopi susu abc":            ["roti bakar coklat keju", "pisang goreng keju", "mendoan hangat (isi 3)"],
    "es good day freeze":       ["roti bakar coklat keju", "pisang goreng keju"],
    "es nutrisari jeruk":       ["gorengan (isi 3)", "kerupuk kaleng"],
    "es milo":                  ["roti bakar coklat keju", "pisang goreng keju"],
    "es extra joss susu":       ["gorengan (isi 3)", "kerupuk kaleng"],
    "teh hangat":               ["gorengan (isi 3)", "roti bakar coklat keju", "mendoan hangat (isi 3)"],
}

# ============================================================
# MODEL DATA
# ============================================================
class OrderRequest(BaseModel):
    menu: str

class LearnRequest(BaseModel):
    items: List[str]

class RecommendationResponse(BaseModel):
    menu_dipilih: str
    rekomendasi: List[str]
    sumber: str
    pesan: str

# ============================================================
# ALGORITMA COLLABORATIVE FILTERING
# ============================================================
def get_recommendation_ai(menu_input: str, top_n: int = 3) -> tuple:
    menu_bersih   = menu_input.strip().lower()
    semua_pesanan = ambil_semua_pesanan()
    MIN_DATA      = 3
    co_count      = defaultdict(int)
    transaksi_relevan = 0

    for transaksi in semua_pesanan:
        transaksi_lower = [item.lower() for item in transaksi]
        menu_ada = any(
            menu_bersih in item or item in menu_bersih
            for item in transaksi_lower
        )
        if menu_ada:
            transaksi_relevan += 1
            for item in transaksi:
                if menu_bersih not in item.lower() and item.lower() not in menu_bersih:
                    co_count[item] += 1

    if transaksi_relevan >= MIN_DATA and co_count:
        sorted_items = sorted(co_count.items(), key=lambda x: x[1], reverse=True)
        rekomendasi  = [item for item, count in sorted_items[:top_n]]
        return rekomendasi, f"AI Belajar ({transaksi_relevan} data)"

    return get_rule_based(menu_bersih), "Rule-Based (data belum cukup)"


def get_rule_based(menu_bersih: str) -> list:
    if menu_bersih in RULES_FALLBACK:
        return RULES_FALLBACK[menu_bersih]
    for kata_kunci, rekomendasi in RULES_FALLBACK.items():
        if kata_kunci in menu_bersih:
            return rekomendasi
    return ["es teh manis", "kerupuk kaleng"]

# ============================================================
# ENDPOINTS
# ============================================================

@app.get("/")
def root():
    stats = hitung_statistik()
    return {
        "status": "✅ Burjo AI v2.0 Berjalan!",
        "total_data_pesanan": stats["total_transaksi"],
        "info": "Semakin banyak pesanan, semakin pintar AI-nya!"
    }

@app.post("/recommend", response_model=RecommendationResponse)
def rekomendasikan_menu(order: OrderRequest):
    rekomendasi, sumber = get_recommendation_ai(order.menu)
    pesan = f"Cocok ditambah {' atau '.join(rekomendasi)}! 😋"
    return RecommendationResponse(
        menu_dipilih=order.menu,
        rekomendasi=rekomendasi,
        sumber=sumber,
        pesan=pesan
    )

@app.post("/learn")
def belajar_dari_pesanan(data: LearnRequest):
    if len(data.items) < 1:
        return {"status": "error", "pesan": "Pesanan kosong"}
    simpan_pesanan(data.items)
    stats = hitung_statistik()
    return {
        "status": "✅ AI berhasil belajar!",
        "items_dipelajari": data.items,
        "total_data_sekarang": stats["total_transaksi"]
    }

@app.get("/stats")
def lihat_statistik():
    semua = ambil_semua_pesanan()
    stats = hitung_statistik()

    item_count = defaultdict(int)
    for transaksi in semua:
        for item in transaksi:
            item_count[item] += 1

    top_menu = sorted(item_count.items(), key=lambda x: x[1], reverse=True)[:5]

    return {
        "total_transaksi": stats["total_transaksi"],
        "top_5_menu_terpopuler": [{"menu": k, "jumlah": v} for k, v in top_menu],
        "status_ai": "🧠 Siap belajar!" if stats["total_transaksi"] < 3
                     else "🧠 AI sudah belajar dari data nyata!"
    }

# ============================================================
# ENDPOINT BARU: RIWAYAT TRANSAKSI (untuk Dashboard AI)
# ============================================================
@app.get("/riwayat")
def lihat_riwayat():
    """Tampilkan riwayat transaksi yang dipelajari AI"""
    try:
        conn   = sqlite3.connect("orders.db")
        cursor = conn.cursor()
        cursor.execute(
            "SELECT items, timestamp FROM orders ORDER BY id DESC LIMIT 50"
        )
        rows = cursor.fetchall()
        conn.close()

        riwayat = []
        for row in rows:
            items = json.loads(row[0])
            # Format waktu: "2026-05-29T10:30:00" → "2026-05-29 10:30"
            waktu = row[1][:16].replace("T", " ") if row[1] else "-"
            riwayat.append({"items": items, "waktu": waktu})

        return {"total": len(riwayat), "riwayat": riwayat}

    except Exception as e:
        return {"total": 0, "riwayat": [], "error": str(e)}

# ============================================================
# ENDPOINT BARU: RESET DATA AI (untuk Dashboard AI)
# ============================================================
@app.delete("/reset")
def reset_data_ai():
    """Hapus semua data pembelajaran AI — AI kembali ke Rule-Based"""
    try:
        conn   = sqlite3.connect("orders.db")
        cursor = conn.cursor()

        # Hapus semua data
        cursor.execute("DELETE FROM orders")
        conn.commit()

        # Verifikasi: hitung sisa data
        cursor.execute("SELECT COUNT(*) FROM orders")
        sisa = cursor.fetchone()[0]
        conn.close()

        return {
            "status": "success",
            "pesan":  "Semua data AI berhasil dihapus",
            "sisa_data": sisa  # Harus 0
        }

    except Exception as e:
        return {
            "status": "error",
            "pesan":  str(e)
        }

# ============================================================
# JALANKAN SERVER
# ============================================================
if __name__ == "__main__":
    import uvicorn
    uvicorn.run("main:app", host="0.0.0.0", port=8000, reload=True)