<?php declare(strict_types=1);

namespace App\Domain\Provider\Gitlab\Repository;

use App\Domain\Model\User;
use App\Domain\Provider\Gitlab\Model\UserConfig;

interface UserConfigRepository
{
    public function getConfigForUser(User $user): ?UserConfig;
    public function persist(UserConfig $userConfig): void;
}
