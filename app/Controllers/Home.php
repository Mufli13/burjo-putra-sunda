<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\BookingModel;

class Home extends BaseController
{
    /**
     * TAMPILAN MENU PEMBELI
     * Menampilkan menu berdasarkan nomor meja
     */
    public function index($no_meja = 0)
{
    $menuModel = new MenuModel();
    $db = \Config\Database::connect();

    // 1. Ambil rekomendasi terbaik dari AI (berdasarkan nilai confidence tertinggi)
    // Kita ambil 3 saran teratas untuk ditampilkan di bagian atas menu
    $rekomendasi_ai = $db->table('ai_results')
                         ->orderBy('confidence', 'DESC')
                         ->limit(3)
                         ->get()
                         ->getResultArray();

    // 2. Ambil menu yang statusnya 'tersedia'
    $all_menu = $menuModel->where('status', 'tersedia')->findAll();

    $data = [
        'title'          => 'Burjo Putra Sunda',
        'no_meja'        => $no_meja,
        'menu'           => $all_menu,
        'rekomendasi_ai' => $rekomendasi_ai, // Tambahkan ini ke array data
        
        // Kategori manual dengan validasi stok 'tersedia'
        'nasi_telur'   => $menuModel->where(['sub_category' => 'ANEKA NASI TELUR', 'status' => 'tersedia'])->findAll(),
        'nasi_ayam'    => $menuModel->where(['sub_category' => 'ANEKA NASI AYAM', 'status' => 'tersedia'])->findAll(),
        'nasi_goreng'  => $menuModel->where(['sub_category' => 'NASI GORENG', 'status' => 'tersedia'])->findAll(),
        'magelangan'   => $menuModel->where(['sub_category' => 'NASI MAGELANGAN', 'status' => 'tersedia'])->findAll(),
        'mie'          => $menuModel->where(['sub_category' => 'ANEKA MIE', 'status' => 'tersedia'])->findAll(),
        'camilan'      => $menuModel->where(['sub_category' => 'CAMILAN', 'status' => 'tersedia'])->findAll(),
        'toping'       => $menuModel->where(['sub_category' => 'TOPING', 'status' => 'tersedia'])->findAll(),
        'minuman'      => $menuModel->where(['sub_category' => 'MINUMAN', 'status' => 'tersedia'])->findAll(),
    ];

    return view('v_menu_pembeli', $data);
}

    /**
     * PROSES CHECKOUT
     * Menyimpan pesanan ke tabel booking dengan status default 'pending'
     */
    public function checkout()
{
    $bookingModel = new \App\Models\BookingModel();
    
    // Ambil data dari POST
    $no_meja = $this->request->getPost('no_meja');
    $nama    = $this->request->getPost('nama');
    $total   = $this->request->getPost('total');
    $pesanan = $this->request->getPost('pesanan');

    $data = [
        'table_number'  => $no_meja,
        'customer_name' => $nama,
        'total_price'   => $total,
        'order_details' => $pesanan,
        'status'        => 'pending'
    ];

    // Coba simpan ke database
    if ($bookingModel->insert($data)) {
        return $this->response->setJSON(['status' => 'success']);
    } else {
        // Jika gagal, kirim pesan error dari model
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => $bookingModel->errors()
        ]);
    }
}

    /**
     * REDIRECT MEJA
     */
    public function meja($no_meja)
    {
        return $this->index($no_meja);
    }
}