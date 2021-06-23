<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Controller;


use Evrinoma\ContractorBundle\Dto\ContractorApiDto;
use Evrinoma\UtilsBundle\Model\ActiveModel;
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


    protected function deleteContractor(array $query)
    {
        $this->client->restart();

        $this->client->request('DELETE', 'evrinoma/api/contractor/delete', $query);
    }


    protected function getContractor(array $query)
    {
        $this->client->restart();

        $this->client->request('GET', 'evrinoma/api/contractor', $query);
    }

    protected function randomContractor(): array
    {
        return [
            "name"       => "test company",
            "id"         => 1,
            "active"     => "a",
            "created_at" => "2021-06-08 17:46",

        ];
    }
//endregion Protected

//region SECTION: Public
    public function testDelete()
    {
        $query = $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $response = $this->getById(1);
        $this->assertArrayHasKey('data', $response);

        $response = $this->deleteById(1);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_ACCEPTED, $this->client->getResponse()->getStatusCode());

        $response = $this->getById(1);
        $this->assertArrayHasKey('data', $response);

        $entity              = $response['data'];
        $query['isolate']    = $entity['isolate'];
        $query['created_at'] = $entity['created_at'];

        $this->assertCount(1, array_diff($entity, $query));
        $this->assertEquals(ActiveModel::DELETED, $entity['active']);
    }

    public function testDeleteNotFound()
    {
        $response = $this->deleteById(1);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testGet()
    {
        $query = $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->getById(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);

        $entity              = $response['data'];
        $query['isolate']    = $entity['isolate'];
        $query['created_at'] = $entity['created_at'];

        $this->assertCount(0, array_diff($entity, $query));
    }

    public function testGetNotFound()
    {
        $response = $this->getById(1);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

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
        $this->createIdentityDependencyIsolate();

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testPostDublicate()
    {
        $this->createIdentity();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createIdentityDependencyIsolate();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $this->createIdentity();
        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
        $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
        $this->createIdentityDependencyIsolate();
        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
    }

    public function testPostWrong(): void
    {
        $this->createWrong();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }
//endregion Public

//region SECTION: Private
    private function deleteById(int $id): array
    {
        $this->deleteContractor(["class" => $this->getDtoClass(), "id" => $id,]);

        return json_decode($this->client->getResponse()->getContent(), true);
    }

    private function getById(int $id): array
    {
        $this->getContractor(["class" => $this->getDtoClass(), "id" => $id,]);

        return json_decode($this->client->getResponse()->getContent(), true);
    }

    private function createIdentity(): array
    {
        $query = $this->getDefault(["class" => $this->getDtoClass(), "identity" => "1234567890",]);

        $this->createContractor($query);

        return $query;
    }

    private function createIdentityDependency(): array
    {
        $query = $this->getDefault(["class" => $this->getDtoClass(), "identity" => "1234567890", "dependency" => "1234567890"]);

        $this->createContractor($query);

        return $query;
    }

    private function createIdentityDependencyIsolate(): array
    {
        $query = $this->getDefault(["class" => $this->getDtoClass(),]);

        $this->createContractor($query);

        return $query;
    }

    private function createWrong(): array
    {
        $query = $this->getDefault([]);

        $this->createContractor($query);

        return $query;
    }


//region SECTION: Getters/Setters
    public function setUp(): void
    {
        $this->default = $this->randomContractor();

        parent::setUp();
    }
//endregion Getters/Setters
}
