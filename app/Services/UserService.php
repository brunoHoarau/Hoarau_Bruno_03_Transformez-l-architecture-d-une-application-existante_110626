<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

/**
 * Gère la logique métier des utilisateurs.
 */
class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $users
    ) {}

    public function getById(int $id): ?User
    {
        return $this->users->findById($id);
    }
}
