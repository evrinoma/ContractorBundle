<?php

namespace Tests\AppBundle\Controller;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Evrinoma\ContractorBundle\Fixtures\ContractorFixtures;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{
//region SECTION: Fields
    /**
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @var KernelBrowser
     */
    protected KernelBrowser $client;
//endregion Fields

//region SECTION: Protected
    protected function loadContractorFixtures(): void
    {
        $this->load(new ContractorFixtures());
    }
//endregion Protected

//region SECTION: Public
    public function tearDown(): void
    {
        parent::tearDown();

        $purger = new ORMPurger($this->entityManager);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
    }
//endregion Public

//region SECTION: Private
    private function load(Fixture $fixture): void
    {
        $fixture->load($this->entityManager);
    }
//endregion Private

//region SECTION: Getters/Setters
    public function setUp()
    {
        $kernel              = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $schemaTool = new SchemaTool($this->entityManager);
        $metadata   = $this->entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
        $this->client = self::createClient();
    }
//endregion Getters/Setters
}
