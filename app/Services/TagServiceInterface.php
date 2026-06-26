<?php

namespace App\Services;

interface TagServiceInterface
{
    public function getTags(): array;

    public function create(string $name): void;

    public function getNotesByTag(int $tagId): array;
}
