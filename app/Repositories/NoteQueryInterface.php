<?php

namespace App\Repositories;

/**
 * Contrat pour les requêtes de notes avec relations (JOIN).
 * Séparé de NoteRepositoryInterface (ISP) pour éviter d'imposer
 * les méthodes JOIN à des implémentations qui n'en ont pas besoin.
 */
interface NoteQueryInterface
{
    /**
     * Retourne une note avec les données de son utilisateur (JOIN).
     *
     * @return array Ligne brute issue de la requête SQL
     */
    public function findWithUser(int $id): array;

    /**
     * Retourne une note avec les données de son tag (JOIN).
     *
     * @return array Ligne brute issue de la requête SQL
     */
    public function findWithTag(int $id): array;
}
