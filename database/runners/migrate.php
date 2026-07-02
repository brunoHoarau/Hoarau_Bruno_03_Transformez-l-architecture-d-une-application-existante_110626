<?php

require __DIR__ . '/../config/database.php';

$pdo = Database::getConnection();

$migrations = [
    require __DIR__ . '/../migrations/001_create_users_table.php',
    require __DIR__ . '/../migrations/002_create_tags_table.php',
    require __DIR__ . '/../migrations/003_create_notes_table.php',
];

foreach ($migrations as $migration) {
    $migration->up($pdo);
}

echo "Migration OK.\n";
