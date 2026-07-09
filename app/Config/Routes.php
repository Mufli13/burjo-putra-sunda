<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- RUTE PUBLIK (PEMBELI) ---
$routes->get('/', 'Home::index/0');
$routes->get('meja/(:num)', 'Home::index/$1');
$routes->post('home/checkout', 'Home::checkout');

// --- RUTE LOGIN ---
$routes->get('auth/portal', 'Login::index');
$routes->post('auth/verify', 'Login::auth');
$routes->get('auth/logout', 'Login::logout');
$routes->get('auth/lupa-password', 'Login::lupa_password');
$routes->post('auth/proses-lupa', 'Login::proses_lupa_password');

// --- RUTE ADMIN (DIPROTEKSI FILTER AUTH) ---
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    // Dashboard Utama & Monitoring
    $routes->get('/', 'Admin::index');
    $routes->get('check_count', 'Admin::check_count');

    // Manajemen Menu (Stok, Tambah, Edit, Hapus)
    $routes->get('menu', 'Admin::menu');
    $routes->post('save_menu', 'Admin::save_menu');
    $routes->post('update_menu', 'Admin::update_menu');
    $routes->get('delete_menu/(:num)', 'Admin::delete_menu/$1');
    
    // Rute ini untuk fitur "SET HABIS / SET ADA" di Manajemen Menu
    $routes->get('update_status/(:num)/(:any)', 'Admin::update_status/$1/$2');

    // Manajemen Pesanan (Proses & Selesai di Dapur)
    $routes->get('updateStatus/(:num)/(:any)', 'Admin::updateStatus/$1/$2');
    $routes->get('delete/(:num)', 'Admin::deleteOrder/$1');

    // Laporan
    $routes->get('laporan', 'Admin::laporan');
});

// Redirect jika ada yang iseng ngetik /login
$routes->addRedirect('login', 'auth/portal');
$routes->post('admin/add_menu', 'Admin::add_menu');
$routes->get('home/index/(:any)', 'Home::index/$1');
$routes->post('admin/hapusLaporanHarian', 'Admin::hapusLaporanHarian');
$routes->get('admin/ai_dashboard', 'Admin::ai_dashboard');