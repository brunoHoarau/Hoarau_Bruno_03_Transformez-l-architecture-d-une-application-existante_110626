<?php

namespace App\Services;

use App\Models\Note;
use App\Repositories\NoteRepositoryInterface;
use App\Repositories\NoteQueryInterface;

/**
 * Gère la logique métier des notes.
 *
 * Dépend de deux interfaces séparées (ISP) :
 * - NoteRepositoryInterface pour le CRUD
 * - NoteQueryInterface pour les requêtes avec relations (JOIN)
 */
class NoteService implements NoteServiceInterface
{
    public function __construct(
        private NoteRepositoryInterface $notes,
        private NoteQueryInterface      $noteQuery
    ) {}

    /**
     * @param int $userId Identifiant issu de la session (jamais du corps de la requête)
     */
    public function create(int $userId, int $tagId, string $text): void
    {
        $this->notes->save(new Note(null, $userId, $tagId, $text));
    }

    /**
     * @throws \Exception Si la note n'existe pas
     */
    public function getNote(int $id): array
    {
        $note = $this->notes->findById($id);

        if (!$note) {
            throw new \Exception("Note not found");
        }

        return ['note' => $note];
    }

    public function getNoteWithRelations(int $id): array
    {
        return [
            'note_user' => $this->noteQuery->findWithUser($id),
            'note_tag'  => $this->noteQuery->findWithTag($id)
        ];
    }
}
