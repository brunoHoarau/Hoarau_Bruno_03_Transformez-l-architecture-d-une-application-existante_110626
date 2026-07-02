<?php

interface FactoryInterface
{
    /** Retourne un tableau de données aléatoires prêt pour l'insertion en base. */
    public static function make(array $context = []): array;
}
