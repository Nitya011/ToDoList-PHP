<?php

return [
    'database' => [
        'name' => 'mytodo',
        'username' => 'root',
        'password' => 'nitya_root',
        'connection' => 'mysql:host=127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];