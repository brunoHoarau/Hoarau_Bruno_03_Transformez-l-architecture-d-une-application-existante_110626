<?php

namespace App\Services\Auth;

interface VerifyEmailServiceInterface
{
    public function verify(int $id, string $token): void;
}
