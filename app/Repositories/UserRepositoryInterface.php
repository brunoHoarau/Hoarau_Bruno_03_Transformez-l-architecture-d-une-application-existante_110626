<?php

namespace App\Repositories;

use PDO;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private PDO $pdo) {}

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users WHERE email = ?
        ");

        $stmt->execute([$email]);

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new User(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['password']
        );
    }
}