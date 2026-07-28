# Notes API

API PHP (sans framework) pour une application de prise de notes avec authentification, notes et tags. Architecture en couches : Controllers → Services → Repositories, avec interfaces pour découpler la logique métier de l'accès aux données (PDO/MySQL).

## Stack

- PHP (PSR-4 autoloading via Composer)
- PDO / MySQL
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) pour la configuration `.env`

## Structure du projet

```
app/
├── Controllers/     # Points d'entrée HTTP (Auth, Note, Tag, User)
├── Services/        # Logique métier (interfaces + implémentations)
├── Repositories/    # Accès aux données via PDO (interfaces + implémentations)
├── Security/        # Hash de mot de passe, gestion de session, génération de tokens
├── Models/          # Entités (Note, Tag, User)
└── Core/            # Router

database/
├── config/          # Connexion PDO (Database::getConnection)
├── migrations/      # Migrations des tables (users, tags, notes)
├── seeders/         # Peuplement de données de test
├── factories/       # Factories pour générer des données de test
└── runners/         # Scripts CLI : fresh, migrate, seed

public/
└── index.php        # Front controller : routes, CORS, injection des dépendances
```

## Prérequis

- PHP >= 8.0 avec l'extension `pdo_mysql`
- [Composer](https://getcomposer.org/)
- Un serveur MySQL/MariaDB

## Installation

```bash
composer install
cp .env.example .env
```

Renseigner les variables dans `.env` :

| Variable | Description |
|---|---|
| `DB_HOST` | Hôte MySQL |
| `DB_PORT` | Port MySQL |
| `DB_NAME` | Nom de la base de données |
| `DB_USER` | Utilisateur MySQL |
| `DB_PASS` | Mot de passe MySQL |
| `CORS_ALLOWED_ORIGINS` | Origines autorisées pour le front (séparées par des virgules) |

## Base de données

```bash
# Créer/mettre à jour les tables
php database/runners/migrate.php

# Supprimer puis recréer toutes les tables
php database/runners/fresh.php

# Peupler la base avec des données de test
php database/runners/seed.php
```

## Lancer le serveur de développement

```bash
php -S localhost:8000 -t public
```

## Routes de l'API

| Méthode | Route | Description |
|---|---|---|
| POST | `/api/login` | Connexion |
| POST | `/api/register` | Inscription |
| GET | `/api/verify-email/{id}/{hash}` | Vérification d'email |
| POST | `/api/logout` | Déconnexion |
| GET | `/api/notes` | Liste des notes |
| POST | `/api/notes` | Créer une note |
| GET | `/api/notes/{id}` | Détail d'une note |
| PUT | `/api/notes/{id}` | Modifier une note |
| DELETE | `/api/notes/{id}` | Supprimer une note |
| GET | `/api/tags` | Liste des tags |
| POST | `/api/tags` | Créer un tag |
| DELETE | `/api/tags/{id}` | Supprimer un tag |
| GET | `/api/test` | Vérification que l'API répond |
