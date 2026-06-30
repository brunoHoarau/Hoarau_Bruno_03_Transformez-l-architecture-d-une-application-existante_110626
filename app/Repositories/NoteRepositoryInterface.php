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

    /** Met à jour le texte et le tag d'une note existante. */
    public function update(Note $note): void;

    /** Supprime une note par son identifiant. */
    public function delete(int $id): void;
}
