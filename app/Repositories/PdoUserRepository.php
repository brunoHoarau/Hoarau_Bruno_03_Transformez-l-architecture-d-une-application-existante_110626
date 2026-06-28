<?php

namespace App\Repositories;

use PDO;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class PdoUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $data = $stmt->fetch();

        return $data ? $this->map($data) : null;
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);

        $data = $stmt->fetch();

        return $data ? $this->map($data) : null;
    }

    public function save(User $user): void
    {
        if ($user->getId() === null) {
            $stmt = $this->pdo->prepare("
                INSERT INTO users (name, email, password, email_verified_at, email_verification_token)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $user->getName(),
                $user->getEmail(),
                $user->getPassword(),
                $user->isEmailVerified() ? date('Y-m-d H:i:s') : null,
                $user->getEmailVerificationToken()
            ]);
        } else {
            $stmt = $this->pdo->prepare("
                UPDATE users
                SET name = ?, email = ?, password = ?, email_verified_at = ?, email_verification_token = ?
                WHERE id = ?
            ");

            $stmt->execute([
                $user->getName(),
                $user->getEmail(),
                $user->getPassword(),
                $user->isEmailVerified() ? date('Y-m-d H:i:s') : null,
                $user->getEmailVerificationToken(),
                $user->getId()
            ]);
        }
    }

    private function map(array $data): User
    {
        return new User(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['password'],
            $data['email_verified_at']
                ? new \DateTime($data['email_verified_at'])
                : null,
            $data['email_verification_token'] ?? null
        );
    }
}
