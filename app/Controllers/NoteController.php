<?php

namespace App\Controllers;

use App\Services\NoteServiceInterface;

class NoteController extends UserController
{
    public function __construct(
        private NoteServiceInterface $service
    ) {}

    public function indexNote(): void
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->error('Unauthenticated', 401);
            return;
        }

        $notes = $this->service->listByUser($userId);
        $this->success(['notes' => $notes]);
    }

    public function createNote(): void
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->error('Unauthenticated', 401);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $this->service->create($userId, (int) $data['tag_id'], $data['text']);
            $this->success(null, 'Note created', 201);
        } catch (\Exception $e) {
            $this->error($e->getMessage(), 400);
        }
    }

    public function showNote(int $id): void
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->error('Unauthenticated', 401);
            return;
        }

        try {
            $this->success($this->service->getNote($id));
        } catch (\Exception $e) {
            $this->error($e->getMessage(), 404);
        }
    }

    public function updateNote(int $id): void
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->error('Unauthenticated', 401);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $this->service->update($id, $userId, (int) $data['tag_id'], $data['text']);
            $this->success(null, 'Note updated');
        } catch (\Exception $e) {
            $status = $e->getMessage() === 'Forbidden' ? 403 : 404;
            $this->error($e->getMessage(), $status);
        }
    }

    public function deleteNote(int $id): void
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->error('Unauthenticated', 401);
            return;
        }

        try {
            $this->service->delete($id, $userId);
            $this->success(null, 'Note deleted');
        } catch (\Exception $e) {
            $status = $e->getMessage() === 'Forbidden' ? 403 : 404;
            $this->error($e->getMessage(), $status);
        }
    }
}
