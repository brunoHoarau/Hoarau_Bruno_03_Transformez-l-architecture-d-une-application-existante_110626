<?php

namespace App\Models;

/**
 * Représente une note créée par un utilisateur.
 */
class Note implements \JsonSerializable
{
    /**
     * @param int|null $id     Identifiant en base (null avant la première sauvegarde)
     * @param int      $userId Identifiant de l'utilisateur propriétaire
     * @param int      $tagId  Identifiant du tag associé
     * @param string   $text   Contenu de la note
     */
    public function __construct(
        private ?int $id,
        private int $userId,
        private int $tagId,
        private string $text
    ) {}

    public function getId(): ?int { return $this->id; }
    public function getUserId(): int { return $this->userId; }
    public function getTagId(): int { return $this->tagId; }
    public function getText(): string { return $this->text; }

    public function updateText(string $text): void
    {
        $this->text = $text;
    }

    public function updateTagId(int $tagId): void
    {
        $this->tagId = $tagId;
    }

    public function jsonSerialize(): mixed
    {
        return ['id' => $this->id, 'user_id' => $this->userId, 'tag_id' => $this->tagId, 'text' => $this->text];
    }
}
