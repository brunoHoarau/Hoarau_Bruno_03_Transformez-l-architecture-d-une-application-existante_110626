<?php

require_once __DIR__ . '/../core/FactoryInterface.php';

class NoteFactory implements FactoryInterface
{
    private static array $templates = [
        'Penser à %s avant la fin de la semaine.',
        'Ne pas oublier de %s.',
        'Rappel : %s.',
        'Important — %s.',
        'À faire : %s.',
        'Note : %s.',
        'Idée intéressante sur %s.',
        'Revoir %s demain matin.',
    ];

    private static array $subjects = [
        'appeler le client', 'finir le rapport', 'vérifier les emails',
        'préparer la présentation', 'commander les fournitures',
        'relire le contrat', 'mettre à jour le tableau de bord',
        'contacter l\'équipe', 'planifier la réunion', 'archiver les documents',
    ];

    public static function make(array $context = []): array
    {
        $template = self::$templates[array_rand(self::$templates)];
        $subject  = self::$subjects[array_rand(self::$subjects)];

        return [
            'user_id' => $context['user_id'],
            'tag_id'  => $context['tag_id'],
            'text'    => sprintf($template, $subject),
        ];
    }
}
