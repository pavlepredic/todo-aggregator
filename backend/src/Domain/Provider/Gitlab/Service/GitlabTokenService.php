<?php declare(strict_types=1);

namespace App\Domain\Provider\Gitlab\Service;

use App\Domain\Model\User;
use App\Domain\Provider\Gitlab\Repository\UserConfigRepository;
use App\Infrastructure\Entity\Gitlab\UserConfig;

class GitlabTokenService
{
    /**
     * @var UserConfigRepository
     */
    private $repository;

    public function __construct(UserConfigRepository $repository)
    {
        $this->repository = $repository;
    }

    public function configureTokenForUser(string $token, User $user): void
    {
        $userConfig = $this->repository->getConfigForUser($user);
        if ($userConfig) {
            $userConfig->setAccessToken($token);
        } else {
            $userConfig = new UserConfig();
            $userConfig->setAccessToken($token);
            $userConfig->setUserId($user->getId());
        }

        $this->repository->persist($userConfig);
    }
}
