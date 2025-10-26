<?php

return [
    'dinkes' => [
        'base_uri' => env('ESB_DINKES_BASE_URI', 'http://localhost:5256/api'),
        'auth' => null,
    ],
    'dinpu' => [
        'base_uri' => env('ESB_DINPU_BASE_URI', 'http://localhost:3000/api_pu.php'),
        'auth' => null,
    ],
    'dinduk' => [
        'base_uri' => env('ESB_DINDUK_BASE_URI', 'http://10.152.21.47:5000/api/kependudukan'),
        'auth' => null,
    ],
];
