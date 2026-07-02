<?php

interface SeederInterface
{
    /** Insère les données de test en base. */
    public function run(PDO $pdo): void;
}
