<?php

namespace App\Repositories;

use PDO;
use App\Models\Tag;
use App\Repositories\TagRepositoryInterface;

class PdoTagRepository implements TagRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function findById(int $id): ?Tag
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tags WHERE id = ?");
        $stmt->execute([$id]);

        $data = $stmt->fetch();

        return $data ? new Tag($data['id'], $data['name']) : null;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM tags");

        return array_map(
            fn($row) => new Tag($row['id'], $row['name']),
            $stmt->fetchAll()
        );
    }

    public function save(Tag $tag): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO tags (name) VALUES (?)
        ");

        $stmt->execute([$tag->getName()]);
    }

    public function findByNoteId(int $noteId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT t.*
            FROM tags t
            JOIN note_tag nt ON nt.tag_id = t.id
            WHERE nt.note_id = ?
        ");

        $stmt->execute([$noteId]);

        return array_map(
            fn($row) => new Tag($row['id'], $row['name']),
            $stmt->fetchAll()
        );
    }
}