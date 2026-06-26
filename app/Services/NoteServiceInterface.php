<?php

namespace App\Services;

interface NoteServiceInterface
{
    public function create(int $userId, int $tagId, string $text): void;

    public function getNote(int $id): array;

    public function getNoteWithRelations(int $id): array;
}
