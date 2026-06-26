<?php

namespace App\Security;

use App\Models\User;

/**
 * Gère la session PHP de l'utilisateur authentifié.
 */
class SessionManager implements SessionManagerInterface
{
    public function start(User $user): void
    {
        $_SESSION['user_id'] = $user->getId();
    }

    public function destroy(): void
    {
        session_destroy();
    }
}
