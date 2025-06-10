<?php

namespace App\Controllers;

class Praktikum extends BaseController
{
    public function pretest()
    {
        return "Pretest Web Programming";
    }

    public function profil()
    {
        return view('profil_mahasiswa');
    }

    public function tambah()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_mahasiswa');

        $data = [
            'nim'  => '32602300055',
            'nama' => 'Muflikhatus Solikhah',
            'prodi'  => 'Teknik Informatika',
        ];

        $builder->insert($data);

        return "<h1>Status</h1><p>Satu record data mahasiswa berhasil ditambahkan!</p>";
    }

    public function tampil()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_mahasiswa');

        $query = $builder->get();
        $data['mahasiswa'] = $query->getResultArray();

        return view('tampil_data', $data);
    }
}