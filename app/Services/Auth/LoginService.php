<?php

namespace App\Services\Auth;

use App\Repositories\UserRepositoryInterface;
use App\Security\PasswordHasherInterface;
use App\Security\SessionManagerInterface;

/**
 * Gère l'authentification d'un utilisateur.
 */
class LoginService implements LoginServiceInterface
{
    public function __construct(
        private UserRepositoryInterface  $users,
        private PasswordHasherInterface  $hasher,
        private SessionManagerInterface  $session
    ) {}

    /**
     * @throws \Exception Si l'utilisateur n'existe pas ou si le mot de passe est incorrect
     */
    public function login(string $email, string $password): void
    {
        $user = $this->users->findByEmail($email);

        if (!$user) {
            throw new \Exception("User not found");
        }

        if (!$this->hasher->verify($password, $user->getPassword())) {
            throw new \Exception("Invalid credentials");
        }

        $this->session->start($user);
    }
}
