<?php

namespace App\Controllers;

use App\Services\NoteServiceInterface;

class NoteController extends UserController
{
    public function __construct(
        private NoteServiceInterface $service
    ) {}

    public function store(): void
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->json(['error' => 'Unauthenticated'], 401);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $this->service->create($userId, $data['tag_id'], $data['text']);
            $this->json(['message' => 'Note created'], 201);
        } catch (\Exception $e) {
            $this->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(int $id): void
    {
        try {
            $this->json($this->service->getNote($id));
        } catch (\Exception $e) {
            $this->json(['error' => $e->getMessage()], 404);
        }
    }
}
