<?php

return [
    'fpx' => [
        'exchange_id' => env('FPX_EX_ID', ''),
        'seller_id' => env('FPX_SELLER_ID', ''),
        'cert_path' => env('FPX_CERT_PATH', ''),
        'cert_fpx_filename' => env('FPX_CERT_FPX_FILENAME', ''),
        'cert_exchange_filename' => env('FPX_CERT_EX_FILENAME', ''),
    ],
];

