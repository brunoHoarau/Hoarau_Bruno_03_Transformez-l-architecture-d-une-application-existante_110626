<?php

namespace App\Controllers;

/**
 * Contrôleur de base.
 *
 * Fournit des utilitaires communs à tous les contrôleurs, notamment
 * l'envoi de réponses JSON avec le bon code HTTP et l'en-tête Content-Type.
 */
abstract class UserController
{
    /**
     * Envoie une réponse JSON.
     *
     * @param mixed $data   Données à sérialiser
     * @param int   $status Code HTTP (200 par défaut)
     */
    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
