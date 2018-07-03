<?php

require './vendor/autoload.php';
require './config/config.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Component\ServiceAutoloader;

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

$container['db'] = function($c) {
    $db = $c['settings']['db'];

    $dsn = "mysql:host={$db['host']};dbname={$db['db_name']};charset=utf8";

    $usr = $db['user'];

    $pwd = $db['password'];

    $pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

    return $pdo;
};

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('dev_logs');

    $file_handler = new \Monolog\Handler\StreamHandler("./logs/dev.log");

    $logger->pushHandler($file_handler);

    return $logger;
};

$container['service_autoloader'] = function ($c) {
    return new ServiceAutoloader($c);
};

require_once './routing.php';

$app->run();