<?php

namespace App\Services\Auth;

interface LoginServiceInterface
{
    public function login(string $email, string $password): void;
}
