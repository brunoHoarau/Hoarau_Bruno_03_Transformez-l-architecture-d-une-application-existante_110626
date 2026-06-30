<?php

require __DIR__ . '/config/Database.php';
require __DIR__ . '/seeders/DataSeeder.php';

$pdo = Database::getConnection();

$seeder = new DataSeeder();
$seeder->run($pdo);

echo "Seeding ok";