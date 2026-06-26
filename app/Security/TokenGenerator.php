<?php

namespace App\Security;

/**
 * Génère des tokens cryptographiquement sûrs.
 */
class TokenGenerator implements TokenGeneratorInterface
{
    public function generate(): string
    {
        return bin2hex(random_bytes(32));
    }
}
