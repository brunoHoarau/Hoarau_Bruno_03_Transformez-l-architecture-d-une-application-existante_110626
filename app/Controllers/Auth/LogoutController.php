<?php

namespace App\Controllers\Auth;

use App\Controllers\UserController;
use App\Services\Auth\LogoutServiceInterface;

class LogoutController extends UserController
{
    public function __construct(
        private LogoutServiceInterface $service
    ) {}

    public function __invoke(): void
    {
        $this->service->logout();
        $this->success(null, 'Logged out');
    }
}
