<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table      = 'booking';
    protected $primaryKey = 'id';

    // Kolom yang boleh diisi (Harus sama dengan di database)
    protected $allowedFields = ['table_number', 'customer_name', 'order_details', 'total_price', 'status'];

    // Menggunakan return type array agar mudah dibaca di View
    protected $returnType = 'array';
}