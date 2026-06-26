<?php

namespace App\Services;

use App\Repositories\TagRepositoryInterface;

/**
 * Gère la logique métier des tags.
 */
class TagService implements TagServiceInterface
{
    public function __construct(
        private TagRepositoryInterface $tags
    ) {}

    /** @return \App\Models\Tag[] */
    public function getTags(): array
    {
        return $this->tags->findAll();
    }

    public function create(string $name): void
    {
        $this->tags->save(new \App\Models\Tag(null, $name));
    }

    /** @return \App\Models\Tag[] */
    public function getNotesByTag(int $tagId): array
    {
        return $this->tags->findByNoteId($tagId);
    }
}
