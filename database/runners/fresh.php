<?php

require __DIR__ . '/../config/database.php';

$pdo = Database::getConnection();

// Désactive les foreign key checks pour pouvoir dropper dans n'importe quel ordre
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("DROP TABLE IF EXISTS notes");
$pdo->exec("DROP TABLE IF EXISTS tags");
$pdo->exec("DROP TABLE IF EXISTS users");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

$migrations = [
    require __DIR__ . '/../migrations/001_create_users_table.php',
    require __DIR__ . '/../migrations/002_create_tags_table.php',
    require __DIR__ . '/../migrations/003_create_notes_table.php',
];

foreach ($migrations as $migration) {
    $migration->up($pdo);
}

echo "Fresh OK — toutes les tables recrées.\n";
