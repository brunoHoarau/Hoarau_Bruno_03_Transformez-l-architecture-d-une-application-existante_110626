<?php

namespace App\Services\Auth;

interface RegisterServiceInterface
{
    public function register(string $name, string $email, string $password): void;
}
