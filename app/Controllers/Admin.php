<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\MenuModel;

class Admin extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('auth/portal'))->send();
            exit();
        }
    }

    // ============================================================
    // DASHBOARD PESANAN
    // ============================================================
    public function index()
    {
        $bookingModel = new BookingModel();
        $data = [
            'title'  => "Panel Kasir - Putra Sunda",
            'orders' => $bookingModel->whereIn('status', ['pending', 'proses'])
                                     ->orderBy('order_date', 'DESC')
                                     ->findAll()
        ];
        return view('v_admin_dashboard', $data);
    }

    // ============================================================
    // UPDATE STATUS PESANAN
    // ============================================================
    public function updateStatus($id, $status)
    {
        $bookingModel = new BookingModel();
        if ($bookingModel->find($id)) {
            $bookingModel->update($id, ['status' => $status]);
            $pesan = ($status == 'proses') ? 'Pesanan sedang dimasak!' : 'Pesanan selesai!';
            return redirect()->to(base_url('admin'))->with('message', $pesan);
        }
        return redirect()->to(base_url('admin'))->with('error', 'Pesanan tidak ditemukan.');
    }

    // ============================================================
    // LAPORAN HARIAN — filter hari ini + tanggal Indonesia
    // ============================================================
    public function laporan()
    {
        $db    = \Config\Database::connect();
        $today = date('Y-m-d');

        // Ambil pesanan hari ini saja (status selesai)
        $orders = $db->query("
            SELECT * FROM booking
            WHERE DATE(order_date) = '$today'
            AND status = 'selesai'
            ORDER BY order_date DESC
        ")->getResultArray();

        // Hitung omzet
        $omzet = 0;
        foreach ($orders as $o) {
            $omzet += $o['total_price'];
        }

        // Rekap kuantitas per menu
        $rekap_menu = [];
        foreach ($orders as $o) {
            if (!empty($o['order_details'])) {
                $items = explode(', ', $o['order_details']);
                foreach ($items as $item) {
                    if (preg_match('/^(\d+)x\s+(.+)$/i', trim($item), $m)) {
                        $qty  = (int) $m[1];
                        $nama = strtoupper(trim($m[2]));
                    } else {
                        $qty  = 1;
                        $nama = strtoupper(trim($item));
                    }
                    $rekap_menu[$nama] = ($rekap_menu[$nama] ?? 0) + $qty;
                }
            }
        }
        arsort($rekap_menu);

        // Format tanggal Indonesia
        $namaHari  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni',
                      'Juli','Agustus','September','Oktober','November','Desember'];
        $tanggalIndo = $namaHari[date('w')] . ', ' . date('d') . ' '
                     . $namaBulan[(int)date('m')] . ' ' . date('Y');

        $data = [
            'title'       => 'Laporan Harian Putra Sunda',
            'tanggal'     => $tanggalIndo,
            'omzet'       => $omzet,
            'rekap_menu'  => $rekap_menu,
            'laporan'     => $orders,
            'total_order' => count($orders),
        ];

        return view('v_admin_laporan', $data);
    }

    // ============================================================
    // HAPUS DATA LAPORAN HARI INI (dipanggil setelah print)
    // ============================================================
    public function hapusLaporanHarian()
{
    // Cek apakah request dari AJAX
    if (!$this->request->isAJAX()) {
        return $this->response->setStatusCode(403)
                              ->setJSON(['status' => 'error', 'pesan' => 'Forbidden']);
    }

    $db    = \Config\Database::connect();
    $today = date('Y-m-d');

    try {
        $db->query("DELETE FROM booking WHERE DATE(order_date) = '$today' AND status = 'selesai'");
        return $this->response->setJSON([
            'status' => 'success',
            'pesan'  => 'Data laporan hari ini berhasil dihapus',
        ]);
    } catch (\Exception $e) {
        return $this->response->setStatusCode(500)
                              ->setJSON([
                                  'status' => 'error',
                                  'pesan'  => $e->getMessage()
                              ]);
    }
}

    // ============================================================
    // DASHBOARD AI RECOMMENDATION
    // ============================================================
    public function ai_dashboard()
    {
        $data = [
            'title' => 'Dashboard AI Recommendation - Putra Sunda',
        ];
        return view('admin/v_admin_ai', $data);
    }

    // ============================================================
    // MANAJEMEN MENU
    // ============================================================
    public function menu()
    {
        $menuModel = new MenuModel();
        $db        = \Config\Database::connect();
        $data = [
            'title'      => 'Manajemen Menu - Putra Sunda',
            'menu'       => $menuModel->findAll(),
            'categories' => $db->table('categories')->get()->getResultArray()
        ];
        return view('v_admin_menu', $data);
    }

    // ============================================================
    // UPDATE DATA MENU
    // ============================================================
    public function update_menu()
    {
        $menuModel = new \App\Models\MenuModel();
        $id        = $this->request->getPost('id');
        $data = [
            'name'         => $this->request->getPost('name'),
            'price'        => $this->request->getPost('price'),
            'sub_category' => $this->request->getPost('sub_category'),
            'category'     => $this->request->getPost('category'),
        ];
        if ($menuModel->update($id, $data)) {
            return redirect()->to(base_url('admin/menu'))->with('message', 'Menu berhasil diperbarui!');
        }
        return redirect()->back()->with('error', 'Gagal memperbarui menu.');
    }

    // ============================================================
    // SIMPAN MENU BARU
    // ============================================================
    public function save_menu()
    {
        $menuModel = new MenuModel();
        $menuModel->save([
            'name'         => $this->request->getPost('name'),
            'sub_category' => $this->request->getPost('category'),
            'price'        => $this->request->getPost('price'),
            'status'       => 'tersedia'
        ]);
        return redirect()->to(base_url('admin/menu'))->with('message', 'Menu berhasil ditambahkan!');
    }

    // ============================================================
    // UPDATE STATUS STOK
    // ============================================================
    public function update_status($id, $status)
    {
        $menuModel = new MenuModel();
        $menuModel->update($id, ['status' => $status]);
        return redirect()->to(base_url('admin/menu'))->with('message', 'Status stok diperbarui!');
    }

    // ============================================================
    // HAPUS MENU
    // ============================================================
    public function delete_menu($id)
    {
        $menuModel = new MenuModel();
        $menuModel->delete($id);
        return redirect()->to(base_url('admin/menu'))->with('message', 'Menu berhasil dihapus!');
    }

    // ============================================================
    // REAL-TIME NOTIFICATION (POLLING)
    // ============================================================
    public function check_count()
{
    $db    = \Config\Database::connect();
    $today = date('Y-m-d');

    $count = $db->query("
        SELECT COUNT(*) as total FROM booking
        WHERE DATE(order_date) = '$today'
        AND status IN ('pending', 'proses')
    ")->getRow()->total;

    return $this->response->setJSON(['count' => (int)$count]);
}

    // ============================================================
    // TAMBAH MENU
    // ============================================================
    public function add_menu()
    {
        $menuModel = new \App\Models\MenuModel();
        $data = [
            'name'         => $this->request->getPost('name'),
            'price'        => $this->request->getPost('price'),
            'sub_category' => $this->request->getPost('sub_category'),
            'status'       => 'tersedia'
        ];
        if ($menuModel->insert($data)) {
            return redirect()->to(base_url('admin/menu'))->with('message', 'Menu ' . $data['name'] . ' Berhasil Ditambahkan!');
        }
        return redirect()->to(base_url('admin/menu'))->with('error', 'Gagal Menambah Menu.');
    }

    // ============================================================
    // JALANKAN AI ANALISIS
    // ============================================================
    public function jalankan_ai()
    {
        $db     = \Config\Database::connect();
        $orders = $db->table('booking')->where('status', 'selesai')->get()->getResultArray();

        $item_counts = [];
        $pair_counts = [];

        foreach ($orders as $row) {
            $raw_items     = explode(', ', $row['order_details']);
            $cleaned_items = [];

            foreach ($raw_items as $item) {
                $name            = preg_replace('/^[0-9]+x\s/', '', $item);
                $name            = trim($name);
                $cleaned_items[] = $name;
                $item_counts[$name] = ($item_counts[$name] ?? 0) + 1;
            }

            for ($i = 0; $i < count($cleaned_items); $i++) {
                for ($j = $i + 1; $j < count($cleaned_items); $j++) {
                    $pair = [$cleaned_items[$i], $cleaned_items[$j]];
                    sort($pair);
                    $key              = implode('|', $pair);
                    $pair_counts[$key] = ($pair_counts[$key] ?? 0) + 1;
                }
            }
        }

        $db->table('ai_results')->truncate();
        foreach ($pair_counts as $pair => $count) {
            $items  = explode('|', $pair);
            $menu_a = $items[0];
            $menu_b = $items[1];
            $conf   = ($count / $item_counts[$menu_a]) * 100;

            if ($conf >= 50) {
                $db->table('ai_results')->insert([
                    'item_awal'         => $menu_a,
                    'item_saran'        => $menu_b,
                    'confidence'        => $conf,
                    'tanggal_analisis'  => date('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->back()->with('message', 'AI Berhasil Menganalisis Pola Transaksi!');
    }
}