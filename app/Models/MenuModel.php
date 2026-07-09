<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table      = 'menu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'sub_category', 'price', 'status'];

    // Fungsi untuk mempermudah mengambil menu berdasarkan kategori
    public function getByCategory($catId)
    {
        return $this->where('category_id', $catId)->where('status', 'tersedia')->findAll();
    }
}