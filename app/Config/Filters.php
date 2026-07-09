<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        // 1. Pastikan nama class-nya Auth (sesuaikan dengan nama file di folder Filters)
        'auth'          => \App\Filters\Auth::class, 
    ];

    public array $globals = [
        'before' => [],
        'after'  => [
            'toolbar',
        ],
    ];

    public array $methods = [];

    // 2. Pastikan array $filters ini berada di dalam class, bukan di luar
    public array $filters = [
        // Ini akan mengunci SEMUA URL yang diawali 'admin'
        'auth' => ['before' => ['admin', 'admin/*']], 
    ];
}