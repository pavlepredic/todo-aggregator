<?php declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\User;

interface Command
{
    public function execute(User $user, array $args = []): string;
    public function supportsArguments(array $args): bool;
}
