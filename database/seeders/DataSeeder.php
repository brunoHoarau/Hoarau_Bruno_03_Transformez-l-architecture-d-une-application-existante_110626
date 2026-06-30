<?php

class DataSeeder
{
    public function run(PDO $pdo): void
    {
        // ======================
        // 1. USER TEST
        // ======================

        $pdo->prepare("
            INSERT INTO users (name, email, password)
            VALUES (?, ?, ?)
        ")->execute([
            'Test User',
            'test@example.com',
            password_hash('password', PASSWORD_BCRYPT)
        ]);

        $userId = $pdo->lastInsertId();

        // ======================
        // 2. TAGS
        // ======================

        $tagStmt = $pdo->prepare("
            INSERT INTO tags (name)
            VALUES (?)
        ");

        $tagIds = [];

        for ($i = 1; $i <= 10; $i++) {
            $tagStmt->execute(["Tag $i"]);
            $tagIds[] = $pdo->lastInsertId();
        }

        // ======================
        // 3. NOTES
        // ======================

        $noteStmt = $pdo->prepare("
            INSERT INTO notes (user_id, tag_id, text)
            VALUES (?, ?, ?)
        ");

        for ($i = 1; $i <= 10; $i++) {
            $noteStmt->execute([
                $userId,
                $tagIds[array_rand($tagIds)],
                "Note de test numéro $i"
            ]);
        }
    }
}