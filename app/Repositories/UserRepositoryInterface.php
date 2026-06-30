<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Contrat de persistance pour les utilisateurs.
 */
interface UserRepositoryInterface
{
    /**
     * Recherche un utilisateur par son identifiant.
     *
     * @return User|null null si non trouvé
     */
    public function findById(int $id): ?User;

    /**
     * Recherche un utilisateur par son adresse email.
     *
     * @return User|null null si non trouvé
     */
    public function findByEmail(string $email): ?User;

    /**
     * Insère ou met à jour un utilisateur en base.
     * INSERT si l'id est null, UPDATE sinon.
     */
    public function save(User $user): void;
}
