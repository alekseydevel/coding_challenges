<?php

require __DIR__.'/vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Transport\Import\XmlProvider;
use Transport\Export\LocalJsonWriter;
use Symfony\Component\Console\Application;
use Transport\Export\OutputDestination\LocalFile;

$application = new Application();

// Injecting dependencies explicitly just for simplicity
// main Command (which is kinda "logic") relies on Interfaces anyway
// the way Injection is made (DI in framework, or other ways) is not so important in this situation.

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (empty($_ENV['LOG_DIR'])) {
    throw new Exception('Log dir is required. Check .env file');
}

$env = $_ENV['ENV'];

$log = new Logger('Dubinin-challenge-logger');
if (strtolower($env) == 'dev') {
    $log->pushHandler(new StreamHandler('php://stdout'));
} else {
    $log->pushHandler(new StreamHandler(sprintf("%s/app.log", $_ENV['LOG_DIR']), Logger::WARNING));
}
$application->add(
    new Command\MigrateData(
        new XmlProvider(),
        new LocalJsonWriter(
            new LocalFile(__DIR__.'/var/output/json_results'.time().'json')
        ),
        $log
    )
);
$application->run();
