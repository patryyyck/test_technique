<?php

require_once __DIR__ . '/vendor/autoload.php';

use Fulll\UI\Cli;

$pdo = new PDO('sqlite:'.__DIR__.'/DB.sqlite');
$pdo->exec("CREATE TABLE IF NOT EXISTS fleets(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER UNIQUE)");
$pdo->exec("CREATE TABLE IF NOT EXISTS vehicles(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    plate_number VARCHAR(20) UNIQUE,
    lat DECIMAL(10,5),
    lng DECIMAL(10,5),
    alt DECIMAL(10,5))");
$pdo->exec("CREATE TABLE IF NOT EXISTS fleets_vehicles(
    fleet_id INTEGER,
    vehicle_id INTEGER UNIQUE)");

$cli = new Cli($pdo);

if ($cli->handle($argv)) {
    exit(0);
}

exit(1);