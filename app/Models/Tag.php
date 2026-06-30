<?php

namespace App\Models;

/**
 * Représente un tag pouvant être associé à une note.
 */
class Tag implements \JsonSerializable
{
    /**
     * @param int|null $id   Identifiant en base (null avant la première sauvegarde)
     * @param string   $name Libellé du tag
     */
    public function __construct(
        private ?int $id,
        private string $name
    ) {}

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }

    public function jsonSerialize(): mixed
    {
        return ['id' => $this->id, 'name' => $this->name];
    }
}
