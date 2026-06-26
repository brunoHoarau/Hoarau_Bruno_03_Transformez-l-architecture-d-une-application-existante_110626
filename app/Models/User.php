<?php

namespace App\Models;

/**
 * Représente un utilisateur de l'application.
 */
class User
{
    /**
     * @param int|null      $id                      Identifiant en base (null avant la première sauvegarde)
     * @param string        $name                    Nom d'affichage
     * @param string        $email                   Adresse email
     * @param string        $password                Mot de passe hashé (bcrypt)
     * @param \DateTime|null $emailVerifiedAt         Date de vérification de l'email (null si non vérifié)
     * @param string|null   $emailVerificationToken  Token à usage unique envoyé par email pour la vérification
     */
    public function __construct(
        private ?int $id,
        private string $name,
        private string $email,
        private string $password,
        private ?\DateTime $emailVerifiedAt = null,
        private ?string $emailVerificationToken = null
    ) {}

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getEmailVerificationToken(): ?string { return $this->emailVerificationToken; }

    public function isEmailVerified(): bool
    {
        return $this->emailVerifiedAt !== null;
    }

    /**
     * Marque l'email comme vérifié et invalide le token de vérification.
     */
    public function markEmailAsVerified(): void
    {
        $this->emailVerifiedAt = new \DateTime();
        $this->emailVerificationToken = null;
    }

    /**
     * Définit le token de vérification d'email.
     * Appelé à l'inscription, avant la sauvegarde en base.
     */
    public function setEmailVerificationToken(string $token): void
    {
        $this->emailVerificationToken = $token;
    }
}
