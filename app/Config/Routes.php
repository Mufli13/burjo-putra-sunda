<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/pretest', 'Praktikum::pretest');
$routes->get('/profil', 'Praktikum::profil');
$routes->get('/tambah-data', 'Praktikum::tambah');
$routes->get('/tampil-data', 'Praktikum::tampil');