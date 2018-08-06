<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Doctrine\DBAL\Migrations\Tools\Console\ConsoleRunner;

$config = require_once dirname(__DIR__).'/config/config.php';

$params = [
   'driver' => $config['db']['driver'],
   'host' => $config['db']['host'],
   'port' => $config['db']['port'],
   'user' => $config['db']['user'],
   'password' => $config['db']['password'],
   'dbname' => $config['db']['db_name'],
];

try {
    $connection = DriverManager::getConnection($params);
} catch (DBALException $e) {
    echo $e->getMessage() . PHP_EOL;
    die;
}

$configuration = new Configuration($connection);
$configuration->setName('Doctrine Migrations');
$configuration->setMigrationsTableName('doctrine_migrations');
$configuration->setMigrationsDirectory(dirname(__DIR__).'/Migrations');
$configuration->setMigrationsNamespace('DoctrineMigrations');

$helperSet = new HelperSet([
    'question' => new QuestionHelper(),
    'db' => new ConnectionHelper($connection),
    'configuration' => new ConfigurationHelper($connection, $configuration),
]);

$cli = ConsoleRunner::createApplication($helperSet);
try {
    $cli->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
