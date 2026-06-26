<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Repositories\PdoUserRepository;
use App\Repositories\PdoNoteRepository;
use App\Repositories\PdoTagRepository;
use App\Security\PasswordHasher;
use App\Security\SessionManager;
use App\Security\TokenGenerator;
use App\Services\Auth\LoginService;
use App\Services\Auth\RegisterService;
use App\Services\Auth\LogoutService;
use App\Services\Auth\VerifyEmailService;
use App\Services\NoteService;
use App\Services\TagService;
use App\Services\UserService;
use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Auth\LogoutController;
use App\Controllers\Auth\VerifyEmailController;
use App\Controllers\NoteController;
use App\Controllers\TagController;

session_start();

// Infrastructure
$pdo = new PDO(
    'mysql:host=localhost;dbname=notes;charset=utf8',
    'root',
    '',
    [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// Repositories
$userRepo = new PdoUserRepository($pdo);
$noteRepo = new PdoNoteRepository($pdo); // implémente NoteRepositoryInterface + NoteQueryInterface
$tagRepo  = new PdoTagRepository($pdo);

// Security
$hasher   = new PasswordHasher();
$session  = new SessionManager();
$tokenGen = new TokenGenerator();

// Services
$loginService       = new LoginService($userRepo, $hasher, $session);
$registerService    = new RegisterService($userRepo, $hasher, $tokenGen);
$logoutService      = new LogoutService($session);
$verifyEmailService = new VerifyEmailService($userRepo);
$noteService        = new NoteService($noteRepo, $noteRepo);
$tagService         = new TagService($tagRepo);
$userService        = new UserService($userRepo);

// Controllers
$loginController       = new LoginController($loginService);
$registerController    = new RegisterController($registerService);
$logoutController      = new LogoutController($logoutService);
$verifyEmailController = new VerifyEmailController($verifyEmailService);
$noteController        = new NoteController($noteService);
$tagController         = new TagController($tagService);

// Routes
$router = new Router();

$router->post('/api/login',                   $loginController);
$router->post('/api/register',                $registerController);
$router->get('/api/verify-email/{id}/{hash}', $verifyEmailController);
$router->post('/api/logout',                  $logoutController);
$router->post('/api/notes',                   [$noteController, 'store']);
$router->get('/api/notes/{id}',               [$noteController, 'show']);
$router->get('/api/tags',                     [$tagController, 'index']);

$router->dispatch();
