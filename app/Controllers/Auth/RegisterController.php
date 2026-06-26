<?php

namespace App\Controllers\Auth;

use App\Controllers\UserController;
use App\Services\Auth\RegisterServiceInterface;

class RegisterController extends UserController
{
    public function __construct(
        private RegisterServiceInterface $service
    ) {}

    public function __invoke(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $this->service->register($data['name'], $data['email'], $data['password']);
            $this->json(['message' => 'User created'], 201);
        } catch (\Exception $e) {
            $this->json(['error' => $e->getMessage()], 400);
        }
    }
}
