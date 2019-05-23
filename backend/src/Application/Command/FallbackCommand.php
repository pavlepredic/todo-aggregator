<?php declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\User;

class FallbackCommand implements Command
{
    public function execute(User $user, array $args = []): string
    {
        return 'Pardon?';
    }

    public function supportsArguments(array $args): bool
    {
        return true;
    }
}
