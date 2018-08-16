<?php

$config = [
    'displayErrorDetails' => true,
    'db' => [
        'driver' => 'pdo_mysql',
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
        'db_name' => 'yolife_dev',
    ],
    'rootDir' => APP_ROOT,
];

return $config;