<?php

namespace App\Repositories;

use App\Models\Note;

/**
 * Contrat de persistance CRUD pour les notes.
 */
interface NoteRepositoryInterface
{
    /**
     * @return Note|null null si non trouvée
     */
    public function findById(int $id): ?Note;

    /**
     * Retourne toutes les notes d'un utilisateur.
     *
     * @return Note[]
     */
    public function findByUserId(int $userId): array;

    /** Insère une note en base. */
    public function save(Note $note): void;
}
