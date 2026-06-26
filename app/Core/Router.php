<?php

namespace App\Core;

/**
 * Routeur HTTP.
 *
 * Enregistre des routes et dispatche les requêtes entrantes vers
 * le callable correspondant. Les contrôleurs sont passés en instances
 * déjà construites (injection manuelle dans index.php).
 *
 * Formats acceptés :
 *   $router->post('/api/login', $loginController);          // __invoke
 *   $router->get('/api/notes/{id}', [$noteCtrl, 'show']);   // méthode nommée
 */
class Router
{
    private array $routes = [];

    public function get(string $path, callable $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, callable $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    public function put(string $path, callable $action): void
    {
        $this->addRoute('PUT', $path, $action);
    }

    public function delete(string $path, callable $action): void
    {
        $this->addRoute('DELETE', $path, $action);
    }

    private function addRoute(string $method, string $path, callable $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'path'   => $this->normalizePath($path),
            'action' => $action,
        ];
    }

    /**
     * Dispatche la requête courante. Retourne 404 JSON si aucune route ne correspond.
     */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = $this->normalizePath(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');

        $params = [];
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->match($route['path'], $uri, $params)) {
                call_user_func_array($route['action'], $params);
                return;
            }
        }

        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Route not found']);
    }

    /**
     * Vérifie si un chemin de route correspond à l'URI et extrait les paramètres dynamiques.
     *
     * @param array $params Tableau rempli avec les paramètres extraits de l'URI
     */
    private function match(string $routePath, string $uri, array &$params = []): bool
    {
        $params = [];

        $routeParts = explode('/', $routePath);
        $uriParts   = explode('/', $uri);

        if (count($routeParts) !== count($uriParts)) {
            return false;
        }

        foreach ($routeParts as $index => $part) {
            if (str_starts_with($part, '{') && str_ends_with($part, '}')) {
                $params[trim($part, '{}')] = $uriParts[$index];
                continue;
            }

            if ($part !== $uriParts[$index]) {
                return false;
            }
        }

        return true;
    }

    private function normalizePath(string $path): string
    {
        return rtrim($path, '/') ?: '/';
    }
}
