<?php

namespace App\Controllers;

use App\Services\TagServiceInterface;

class TagController extends UserController
{
    public function __construct(
        private TagServiceInterface $service
    ) {}

    public function index(): void
    {
        $this->success($this->service->getTags());
    }
}
