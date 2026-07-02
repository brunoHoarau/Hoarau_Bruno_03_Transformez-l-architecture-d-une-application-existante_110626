<?php

interface MigrationInterface
{
    /** Applique la migration (création / modification de table). */
    public function up(PDO $pdo): void;
}
