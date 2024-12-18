<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
    'allowed_origins' => [
        'http://localhost:8000',
        'http://localhost:5173',
        'http://127.0.0.1:8000',
        'http://127.0.0.1:5173',
        'http://localhost:8081',
    ],
    'allowed_origins_patterns' => [], 
    'allowed_headers' => ['Content-Type', 'Authorization', 'Accept'], 
    'exposed_headers' => [],
    'max_age' => 0, 
    'supports_credentials' => true, 
];