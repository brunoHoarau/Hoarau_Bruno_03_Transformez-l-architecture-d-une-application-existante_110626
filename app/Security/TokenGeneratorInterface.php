<?php

namespace App\Security;

interface TokenGeneratorInterface
{
    public function generate(): string;
}
