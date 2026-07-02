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

    public function createTag(): void
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->error('Unauthenticated', 401);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['name'])) {
            $this->error('Tag name is required', 422);
            return;
        }

        try {
            $this->service->create($data['name']);
            $this->success(null, 'Tag created', 201);
        } catch (\Exception $e) {
            $this->error($e->getMessage(), 400);
        }
    }
}
