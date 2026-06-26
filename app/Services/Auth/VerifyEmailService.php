<?php

namespace App\Services\Auth;

use App\Repositories\UserRepositoryInterface;

/**
 * Gère la vérification de l'adresse email d'un utilisateur.
 */
class VerifyEmailService implements VerifyEmailServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $users
    ) {}

    /**
     * Valide le token et marque l'email comme vérifié.
     * Utilise hash_equals pour une comparaison en temps constant (protection timing attack).
     *
     * @throws \Exception Si l'utilisateur n'existe pas ou si le token est invalide
     */
    public function verify(int $id, string $token): void
    {
        $user = $this->users->findById($id);

        if (!$user) {
            throw new \Exception("User not found");
        }

        if (!hash_equals((string) $user->getEmailVerificationToken(), $token)) {
            throw new \Exception("Invalid token");
        }

        $user->markEmailAsVerified();

        $this->users->save($user);
    }
}
