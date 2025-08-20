<?php
return [
    'disk' => env('MEDIA_DISK', 'public'),
    'max_bytes' => env('MEDIA_MAX_BYTES', 5 * 1024 * 1024),
    'max_width' => env('MEDIA_MAX_W', 4096),
    'max_height'=> env('MEDIA_MAX_H', 4096),
    'jpeg_quality' => env('MEDIA_JPEG_Q', 82),
    'allowed_mimes' => [
        'image/jpeg','image/png','image/webp',
    ],
    'variants' => [
        'thumb'  => [320,  320],
        'medium' => [1024, 1024],
    ],
    'clamav' => [
        'enabled' => env('CLAMAV_ENABLED', false),
        'host'    => env('CLAMAV_HOST', '127.0.0.1'),
        'port'    => (int) env('CLAMAV_PORT', 3310),
        'timeout' => (int) env('CLAMAV_TIMEOUT', 5),
    ],
    'temporary_url_ttl' => env('MEDIA_TMP_TTL', 600),
];
