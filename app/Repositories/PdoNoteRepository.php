<?php

namespace App\Repositories;

use PDO;
use App\Models\Note;
use App\Repositories\NoteRepositoryInterface;
use App\Repositories\NoteQueryInterface;

/**
 * Implémentation PDO de NoteRepositoryInterface et NoteQueryInterface.
 * Une seule classe couvre les deux contrats pour éviter la duplication de la connexion PDO.
 */
class PdoNoteRepository implements NoteRepositoryInterface, NoteQueryInterface
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function findById(int $id): ?Note
    {
        $stmt = $this->pdo->prepare("SELECT * FROM notes WHERE id = ?");
        $stmt->execute([$id]);

        $data = $stmt->fetch();

        return $data
            ? new Note($data['id'], $data['user_id'], $data['tag_id'], $data['text'])
            : null;
    }

    public function findByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM notes WHERE user_id = ?");
        $stmt->execute([$userId]);

        return array_map(
            fn($row) => new Note($row['id'], $row['user_id'], $row['tag_id'], $row['text']),
            $stmt->fetchAll()
        );
    }

    public function save(Note $note): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO notes (user_id, tag_id, text) VALUES (?, ?, ?)");

        $stmt->execute([
            $note->getUserId(),
            $note->getTagId(),
            $note->getText()
        ]);
    }

    public function findWithUser(int $id): array
    {
        $stmt = $this->pdo->prepare("
            SELECT n.*, u.id as u_id, u.name, u.email
            FROM notes n
            JOIN users u ON u.id = n.user_id
            WHERE n.id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function findWithTag(int $id): array
    {
        $stmt = $this->pdo->prepare("
            SELECT n.*, t.id as t_id, t.name as tag_name
            FROM notes n
            JOIN tags t ON t.id = n.tag_id
            WHERE n.id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch();
    }
}
