<?php

namespace App\Controllers\Auth;

use App\Controllers\UserController;
use App\Services\Auth\VerifyEmailServiceInterface;

class VerifyEmailController extends UserController
{
    public function __construct(
        private VerifyEmailServiceInterface $service
    ) {}

    public function __invoke(string $id, string $hash): void
    {
        try {
            $this->service->verify((int) $id, $hash);
            $this->json(['message' => 'Email verified']);
        } catch (\Exception $e) {
            $this->json(['error' => $e->getMessage()], 400);
        }
    }
}
