<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Security\PasswordHasherInterface;
use App\Security\TokenGeneratorInterface;

/**
 * Gère l'inscription d'un nouvel utilisateur.
 */
class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $users,
        private PasswordHasherInterface $hasher,
        private TokenGeneratorInterface $tokenGenerator
    ) {}

    /**
     * Crée un utilisateur avec un mot de passe hashé et un token de vérification d'email.
     */
    public function register(string $name, string $email, string $password): void
    {
        $user = new User(null, $name, $email, $this->hasher->hash($password));

        $user->setEmailVerificationToken($this->tokenGenerator->generate());

        try {
            $this->users->save($user);
        } catch (\PDOException $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                throw new \Exception("Email already in use");
            }
            throw $e;
        }
    }
}
