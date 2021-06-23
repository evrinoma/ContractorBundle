<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Controller;


use Evrinoma\ContractorBundle\Dto\ContractorApiDto;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class ApiControllerTest extends AbstractControllerTest
{
//region SECTION: Fields
    private array $default = [];
//endregion Fields

//region SECTION: Protected
    protected function getDtoClass(): string
    {
        return ContractorApiDto::class;
    }

    protected function getDefault(array $extend): array
    {
        return array_merge($extend, unserialize(serialize($this->default)));
    }

    protected function createContractor(array $query)
    {
        $this->client->restart();

        $this->client->request(
            'POST',
            'evrinoma/api/contractor/create',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($query)
        );
    }

    protected function randomContractor(): array
    {
        return [
            "name"       => "test company",
            "id"         => 1,
            "active"     => "a",
            "created_at" => "2021-06-08 17:46",
            "updated_at" => "2021-06-08 17:46",

        ];
    }
//endregion Protected

//region SECTION: Public
    public function testPostIdentity()
    {
        $this->createIdentity();

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testPostIdenityDependency()
    {
        $this->createIdentityDependency();

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testPostIdenityDependencyIsolate()
    {
        $this->createIdenityDependencyIsolate();

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testPostDublicate()
    {
        $this->createIdentity();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createIdenityDependencyIsolate();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $this->createIdentity();
        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
        $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
        $this->createIdenityDependencyIsolate();
        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
    }
//endregion Public

//region SECTION: Private
    private function createIdentity(): void
    {
        $query = $this->getDefault(["class" => $this->getDtoClass(), "identity" => "1234567890",]);

        $this->createContractor($query);
    }

    private function createIdentityDependency(): void
    {
        $query = $this->getDefault(["class" => $this->getDtoClass(), "identity" => "1234567890", "dependency" => "1234567890"]);

        $this->createContractor($query);
    }

    private function createIdenityDependencyIsolate(): void
    {
        $query = $this->getDefault(["class" => $this->getDtoClass(),]);

        $this->createContractor($query);
    }
//endregion Private

//region SECTION: Dto
    public function testPostWrongDto()
    {
        $this->createWrongDto();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }

    private function createWrongDto(): void
    {
        $query = $this->getDefault([]);

        $this->createContractor($query);
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    public function setUp(): void
    {
        $this->default = $this->randomContractor();

        parent::setUp();
    }
//endregion Getters/Setters
}
