<?php

require_once __DIR__ . '/../core/FactoryInterface.php';

class TagFactory implements FactoryInterface
{
    private static array $names = [
        'Travail', 'Personnel', 'Idées', 'Urgent', 'À lire',
        'Projet', 'Réunion', 'Shopping', 'Voyage', 'Santé',
        'Finance', 'Formation', 'Famille', 'Loisirs', 'Divers',
    ];

    public static function make(array $context = []): array
    {
        return [
            'name' => self::$names[array_rand(self::$names)] . ' ' . rand(1, 99),
        ];
    }
}
