<?php

namespace App\Controllers\Auth;

use App\Controllers\UserController;
use App\Services\Auth\LoginServiceInterface;

class LoginController extends UserController
{
    public function __construct(
        private LoginServiceInterface $service
    ) {}

    public function __invoke(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $this->service->login($data['email'], $data['password']);
            $this->success(null, 'Logged in');
        } catch (\Exception $e) {
            $this->error($e->getMessage(), 401);
        }
    }
}
