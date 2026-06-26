<?php

namespace App\Repositories;

use App\Models\Tag;

/**
 * Contrat de persistance pour les tags.
 */
interface TagRepositoryInterface
{
    /**
     * @return Tag|null null si non trouvé
     */
    public function findById(int $id): ?Tag;

    /**
     * Retourne tous les tags disponibles.
     *
     * @return Tag[]
     */
    public function findAll(): array;

    /** Insère un tag en base. */
    public function save(Tag $tag): void;

    /**
     * Retourne les tags associés à une note via la table de liaison note_tag.
     *
     * @return Tag[]
     */
    public function findByNoteId(int $noteId): array;
}
