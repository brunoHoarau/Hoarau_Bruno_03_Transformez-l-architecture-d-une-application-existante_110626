<?php

namespace App\Security;

use App\Models\User;

interface SessionManagerInterface
{
    public function start(User $user): void;

    public function destroy(): void;
}
