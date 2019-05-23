<?php declare(strict_types=1);

namespace App\Infrastructure\Repository\Gitlab;

use App\Domain\Model\User;
use App\Domain\Provider\Gitlab\Model\UserConfig;
use App\Infrastructure\Entity\Gitlab\UserConfig as UserConfigEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Domain\Provider\Gitlab\Repository\UserConfigRepository as UserConfigRepositoryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserConfigRepository extends ServiceEntityRepository implements UserConfigRepositoryInterface
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserConfigEntity::class);
    }

    public function getConfigForUser(User $user): ?UserConfig
    {
        return $this->find($user->getId());
    }

    public function persist(UserConfig $userConfig): void
    {
        /** @var UserConfig $existingConfig */
        $existingConfig = $this->find($userConfig->getUserId());
        if ($existingConfig) {
            $existingConfig->setAccessToken($userConfig->getAccessToken());
        } else {
            $this->getEntityManager()->persist($userConfig);
        }

        $this->getEntityManager()->flush();
    }
}
