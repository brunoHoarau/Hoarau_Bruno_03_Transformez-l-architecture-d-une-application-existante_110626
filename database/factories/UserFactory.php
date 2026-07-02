<?php

require_once __DIR__ . '/../core/FactoryInterface.php';

class UserFactory implements FactoryInterface
{
    private static array $firstNames = ['Alice', 'Bob', 'Clara', 'David', 'Emma', 'Fabien', 'Grace', 'Hugo'];
    private static array $lastNames  = ['Martin', 'Dupont', 'Bernard', 'Petit', 'Robert', 'Simon', 'Leroy'];

    public static function make(array $context = []): array
    {
        $first = self::$firstNames[array_rand(self::$firstNames)];
        $last  = self::$lastNames[array_rand(self::$lastNames)];
        $uid   = substr(md5(uniqid()), 0, 6);

        return [
            'name'              => "$first $last",
            'email'             => strtolower("$first.$last.$uid@example.com"),
            'password'          => password_hash('password', PASSWORD_BCRYPT),
            'email_verified_at' => date('Y-m-d H:i:s'),
        ];
    }
}
