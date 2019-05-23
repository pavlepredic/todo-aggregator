<?php declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DbTestCase extends KernelTestCase
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    protected function setUp()
    {
        parent::setUp();

        self::bootKernel();
        $container = static::$kernel->getContainer();
        $this->entityManager = $container->get('doctrine')->getManager();

        $this->dropDatabase();
        $this->createDatabase();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->dropDatabase();
    }


    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    private function dropDatabase()
    {
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->dropDatabase();
    }

    private function createDatabase()
    {
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($metadata);
    }
}
