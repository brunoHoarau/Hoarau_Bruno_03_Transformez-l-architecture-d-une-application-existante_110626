<?php

namespace App\Services;

interface TagServiceInterface
{
    public function getTags(): array;

    public function create(string $name): void;

    /** @throws \Exception Tag non trouvé */
    public function delete(int $id): void;

    public function getNotesByTag(int $tagId): array;
}
