<?php

namespace App\Services;

interface NoteServiceInterface
{
    public function create(int $userId, int $tagId, string $text): void;

    /** @return array Liste des notes de l'utilisateur */
    public function listByUser(int $userId): array;

    public function getNote(int $id): array;

    public function getNoteWithRelations(int $id): array;

    /** @throws \Exception Note non trouvée ou accès interdit */
    public function update(int $id, int $userId, int $tagId, string $text): void;

    /** @throws \Exception Note non trouvée ou accès interdit */
    public function delete(int $id, int $userId): void;
}
