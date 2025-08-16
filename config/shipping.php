<?php

return [
    'currency' => env('SHOP_CURRENCY','TRY'),
    'free_threshold_minor' => env('SHIPPING_FREE_MINOR', 300_00),
    'carriers' => [
        ['id'=>'standard','name'=>'Standart Kargo','price_minor'=>29_99,'eta_days'=>3],
        ['id'=>'express','name'=>'Hızlı Kargo','price_minor'=>59_99,'eta_days'=>1],
    ],
    'zones' => [
        'TR' => ['multiplier'=>1.0],
        'DE' => ['multiplier'=>1.4],
        'US' => ['multiplier'=>1.8],
    ],
];
