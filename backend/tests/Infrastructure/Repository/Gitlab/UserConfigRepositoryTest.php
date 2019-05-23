<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\Gitlab;

use App\Domain\Model\User;
use App\Infrastructure\Entity\Gitlab\UserConfig;
use App\Infrastructure\Repository\Gitlab\UserConfigRepository;
use App\Tests\DbTestCase;

class UserConfigRepositoryTest extends DbTestCase
{
    /**
     * @var UserConfigRepository
     */
    private $repository;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = $this->getEntityManager()->getRepository(UserConfig::class);

        $config = new UserConfig();
        $config->setUserId('1');
        $config->setAccessToken('token');

        $this->getEntityManager()->persist($config);
        $this->getEntityManager()->flush();
    }

    public function testGetConfigForExistingUser()
    {
        $config = $this->repository->getConfigForUser(new User('1', ''));

        self::assertSame('token', $config->getAccessToken());
    }

    public function testGetConfigForUnknownUser()
    {
        $config = $this->repository->getConfigForUser(new User('2', ''));

        self::assertSame(null, $config);
    }
}
