# ============================================================
# FILE: database.py
# FUNGSI: Menyimpan & membaca data pesanan pembeli
# Menggunakan SQLite (sudah built-in di Python, tanpa install)
# ============================================================

import sqlite3
import json
from datetime import datetime

DB_FILE = "orders.db"  # File database akan dibuat otomatis

def init_db():
    """
    Buat tabel database kalau belum ada.
    Dipanggil sekali saat server pertama kali jalan.
    """
    conn = sqlite3.connect(DB_FILE)
    cursor = conn.cursor()
    
    # Tabel untuk menyimpan setiap transaksi pesanan
    cursor.execute("""
        CREATE TABLE IF NOT EXISTS orders (
            id        INTEGER PRIMARY KEY AUTOINCREMENT,
            items     TEXT NOT NULL,  -- Daftar menu dalam format JSON
            timestamp TEXT NOT NULL   -- Waktu pesan
        )
    """)
    conn.commit()
    conn.close()

def simpan_pesanan(daftar_menu: list):
    """
    Simpan satu transaksi pesanan ke database.
    Contoh input: ["Indomie Goreng Telur", "Es Teh", "Kerupuk"]
    """
    conn = sqlite3.connect(DB_FILE)
    cursor = conn.cursor()
    cursor.execute(
        "INSERT INTO orders (items, timestamp) VALUES (?, ?)",
        (json.dumps(daftar_menu), datetime.now().isoformat())
    )
    conn.commit()
    conn.close()

def ambil_semua_pesanan() -> list:
    """
    Ambil semua transaksi pesanan dari database.
    Return: list of list, contoh:
    [
        ["Indomie Goreng", "Es Teh", "Kerupuk"],
        ["Nasi Goreng", "Es Teh"],
        ...
    ]
    """
    conn = sqlite3.connect(DB_FILE)
    cursor = conn.cursor()
    cursor.execute("SELECT items FROM orders")
    rows = cursor.fetchall()
    conn.close()
    
    # Ubah dari JSON string ke list Python
    return [json.loads(row[0]) for row in rows]

def hitung_statistik() -> dict:
    """Hitung total pesanan dan total item untuk halaman statistik"""
    conn = sqlite3.connect(DB_FILE)
    cursor = conn.cursor()
    cursor.execute("SELECT COUNT(*) FROM orders")
    total_transaksi = cursor.fetchone()[0]
    conn.close()
    return {"total_transaksi": total_transaksi}