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
     * @param int $id Identifiant de l'utilisateur
     * @return User|null null si non trouvé
     */
    public function findById(int $id): ?User;

    /**
     * Recherche un utilisateur par son adresse email.
     *
     * @param string $email Adresse email
     * @return User|null null si non trouvé
     */
    public function findByEmail(string $email): ?User;

    /**
     * Insère ou met à jour un utilisateur en base.
     * INSERT si l'id est null, UPDATE sinon.
     *
     * @param User $user Utilisateur à persister
     */
    public function save(User $user): void;
}
