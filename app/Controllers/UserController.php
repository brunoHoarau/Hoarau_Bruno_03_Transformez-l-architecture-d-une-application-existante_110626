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
    protected function success(mixed $data = null, string $message = '', int $status = 200): void
    {
        $this->json(['status' => 'success', 'message' => $message, 'data' => $data], $status);
    }

    protected function error(string $message, int $status = 400): void
    {
        $this->json(['status' => 'error', 'message' => $message, 'data' => null], $status);
    }

    private function json(mixed $data, int $status): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
