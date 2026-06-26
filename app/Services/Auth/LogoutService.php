<?php

namespace App\Services\Auth;

use App\Security\SessionManagerInterface;

/**
 * Gère la déconnexion d'un utilisateur.
 */
class LogoutService implements LogoutServiceInterface
{
    public function __construct(
        private SessionManagerInterface $session
    ) {}

    public function logout(): void
    {
        $this->session->destroy();
    }
}
