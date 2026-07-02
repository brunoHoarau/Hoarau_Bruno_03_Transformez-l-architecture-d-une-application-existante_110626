<?php

require_once __DIR__ . '/../core/SeederInterface.php';
require_once __DIR__ . '/../factories/UserFactory.php';
require_once __DIR__ . '/../factories/TagFactory.php';
require_once __DIR__ . '/../factories/NoteFactory.php';

class DataSeeder implements SeederInterface
{
    public function run(PDO $pdo): void
    {
        // Utilisateur de test fixe (credentials connus pour Postman)
        $pdo->prepare("
            INSERT INTO users (name, email, password, email_verified_at)
            VALUES (?, ?, ?, NOW())
        ")->execute([
            'Test User',
            'test@example.com',
            password_hash('password', PASSWORD_BCRYPT),
        ]);

        $testUserId = (int) $pdo->lastInsertId();

        // 4 utilisateurs aléatoires via UserFactory
        $userStmt = $pdo->prepare("
            INSERT INTO users (name, email, password, email_verified_at)
            VALUES (:name, :email, :password, :email_verified_at)
        ");

        for ($i = 0; $i < 4; $i++) {
            $userStmt->execute(UserFactory::make());
        }

        // 10 tags via TagFactory
        $tagStmt = $pdo->prepare("INSERT INTO tags (name) VALUES (:name)");
        $tagIds  = [];

        for ($i = 0; $i < 10; $i++) {
            $tagStmt->execute(TagFactory::make());
            $tagIds[] = (int) $pdo->lastInsertId();
        }

        // 10 notes pour l'utilisateur de test via NoteFactory
        $noteStmt = $pdo->prepare("
            INSERT INTO notes (user_id, tag_id, text)
            VALUES (:user_id, :tag_id, :text)
        ");

        for ($i = 0; $i < 10; $i++) {
            $noteStmt->execute(NoteFactory::make(['user_id' => $testUserId, 'tag_id' => $tagIds[array_rand($tagIds)]]));
        }
    }
}
