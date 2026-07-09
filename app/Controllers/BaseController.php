<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // --- KUNCI PAKSA ADMIN (Pasti Berhasil) ---
        // Mengambil layanan URI untuk mengecek alamat yang sedang diakses
        $uri = service('uri');
        
        // Cek apakah segmen pertama URL adalah 'admin'
        // Jika pembeli mengakses halaman menu, segmen1 biasanya kosong atau 'home'
        if ($uri->getSegment(1) == 'admin') {
            
            // Memulai session jika belum otomatis berjalan
            $session = \Config\Services::session();

            // Jika session 'logged_in' tidak ada atau nilainya bukan true
            if (!$session->get('logged_in')) {
                // Paksa lempar ke halaman login menggunakan header PHP murni
                // agar eksekusi berhenti seketika sebelum controller anak dijalankan
                header("Location: " . base_url('login'));
                exit(); 
            }
        }
        // ------------------------------------------
    }
}