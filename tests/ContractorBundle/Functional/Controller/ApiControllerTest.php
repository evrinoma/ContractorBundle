<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Controller;


use Evrinoma\ContractorBundle\Dto\ContractorApiDto;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class ApiControllerTest extends AbstractControllerTest implements ApiControllerTestInterface
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

    protected function createContractor(array $query): void
    {
        $this->client->restart();

        $this->client->request('POST', 'evrinoma/api/contractor/create', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($query));
    }


    protected function deleteContractor(array $query): void
    {
        $this->client->restart();

        $this->client->request('DELETE', 'evrinoma/api/contractor/delete', $query);
    }

    protected function putContractor(array $query): void
    {
        $this->client->restart();

        $this->client->request('PUT', 'evrinoma/api/contractor/save', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($query));
    }

    protected function getContractor(array $query): void
    {
        $this->client->restart();

        $this->client->request('GET', 'evrinoma/api/contractor', $query);
    }

    protected function criteriaContractor(array $query): void
    {
        $this->client->restart();

        $this->client->request('GET', 'evrinoma/api/contractor/criteria', $query);
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
    public function testCriteria(): void
    {
        $this->createIdentity();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $query = $this->createIdentityDependencyIsolate();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->criteria( ["identity" => "1234567890"]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);
        $response = $this->criteria( ["identity" => md5($query['name'])]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(1, $response['data']);
    }

    public function testCriteriaNotFound(): void
    {
        $this->createIdentity();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->criteria( ["identity" => "0987654321"]);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
    }

    public function testPut(): void
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

        $query["identity"] = "0987654321";
        $query["active"]   = ActiveModel::BLOCKED;

        $this->put($query);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testPutNotFound(): void
    {
        $query = [
            "class"    => $this->getDtoClass(),
            "id"       => "1",
            "identity" => "0987654321",
            "active"   => ActiveModel::BLOCKED,
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testPutUnprocessable(): void
    {
        $query = [
            "class"    => $this->getDtoClass(),
            "id"       => "",
            "identity" => "0987654321",
            "active"   => ActiveModel::BLOCKED,
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }


    public function testDelete(): void
    {
        $query = $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $response = $this->getById(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);

        $response = $this->deleteById('1');
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

    public function testDeleteNotFound(): void
    {
        $response = $this->deleteById('1');
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteUnprocessable(): void
    {
        $response = $this->deleteById('');
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }


    public function testGet(): void
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

    public function testGetNotFound(): void
    {
        $response = $this->getById(1);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testPostIdentity(): void
    {
        $this->createIdentity();

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testPostIdenityDependency(): void
    {
        $this->createIdentityDependency();

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testPostIdenityDependencyIsolate(): void
    {
        $this->createIdentityDependencyIsolate();

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testPostDuplicate(): void
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

    public function testPostUnprocessable(): void
    {
        $this->createWrong();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }
//endregion Public

//region SECTION: Private
    private function deleteById(string $id): array
    {
        $this->deleteContractor(["class" => $this->getDtoClass(), "id" => $id,]);

        return json_decode($this->client->getResponse()->getContent(), true);
    }

    private function getById(int $id): array
    {
        $this->getContractor(["class" => $this->getDtoClass(), "id" => $id,]);

        return json_decode($this->client->getResponse()->getContent(), true);
    }

    private function criteria(array $query): array
    {
        $this->criteriaContractor(array_merge(["class" => $this->getDtoClass()], $query));

        return json_decode($this->client->getResponse()->getContent(), true);
    }


    private function put(array $query): array
    {
        $this->putContractor($query);

        return $query;
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
