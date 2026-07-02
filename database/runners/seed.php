<?php

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../seeders/DataSeeder.php';

$pdo = Database::getConnection();

$seeder = new DataSeeder();
$seeder->run($pdo);

echo "Seeding OK.\n";
