<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Controller;


use Evrinoma\ContractorBundle\Dto\ContractorApiDto;
use Evrinoma\ContractorBundle\Tests\Functional\CaseTest;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestTrait;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiHelperTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiHelperTestTrait;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class ApiControllerTest extends CaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiHelperTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/contractor';
    public const API_CRITERIA = 'evrinoma/api/contractor/criteria';
    public const API_DELETE   = 'evrinoma/api/contractor/delete';
    public const API_PUT      = 'evrinoma/api/contractor/save';
    public const API_POST     = 'evrinoma/api/contractor/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiHelperTestTrait;

//region SECTION: Protected
    protected function getFixtures(): array
    {
        return [];
    }

    protected static function getDtoClass(): string
    {
        return ContractorApiDto::class;
    }

    protected static function defaultData(): array
    {
        return [
            "name"       => "test company",
            "id"         => 1,
            "active"     => "a",
            "created_at" => "2021-06-08 17:46",
            "class"      => static::getDtoClass(),
        ];
    }
//endregion Protected

//region SECTION: Public
    public function testCriteria(): void
    {
        $query = $this->getDefault();

        $this->createIdentity();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createIdentityDependencyIsolate();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => "1234567890"]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => md5($query['name'])]);
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

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => "0987654321"]);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
    }

    public function testPut(): void
    {
        $created = $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $find = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertCount(0, array_diff($created['data'], $find['data']));

        $query = [
            "class"    => static::getDtoClass(),
            "id"       => $find['data']['id'],
            "identity" => "0987654321",
            "active"   => ActiveModel::BLOCKED,
            "name"     => $find['data']['name'],
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testPutNotFound(): void
    {
        $query = [
            "class"    => static::getDtoClass(),
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
            "class"    => static::getDtoClass(),
            "id"       => "",
            "identity" => "0987654321",
            "active"   => ActiveModel::BLOCKED,
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $created = $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $query = [
            "id"       => "1",
            "identity" => "0987654321",
            "active"   => ActiveModel::BLOCKED,
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }

    public function testDelete(): void
    {
        $created = $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $find = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $response = $this->delete('1');
        $this->assertEquals(Response::HTTP_ACCEPTED, $this->client->getResponse()->getStatusCode());

        $delete = $this->get(1);

        $this->assertArrayHasKey('data', $delete);
        $this->assertArrayHasKey('data', $response);

        $this->assertCount(1, array_diff($find['data'], $delete['data']));
        $this->assertEquals(ActiveModel::DELETED, $delete['data']['active']);
    }

    public function testDeleteNotFound(): void
    {
        $response = $this->delete('1');
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteUnprocessable(): void
    {
        $response = $this->delete('');
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }

    public function testGet(): void
    {
        $created = $this->createIdentityDependency();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $find = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertCount(0, array_diff($created['data'], $find['data']));
    }

    public function testGetNotFound(): void
    {
        $response = $this->get(1);
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
        $this->postWrong();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }
//endregion Public

//region SECTION: Private
    private function createIdentity(): array
    {
        $query = $this->getDefault(["identity" => "1234567890",]);

        return $this->post($query);
    }

    private function createIdentityDependency(): array
    {
        $query = $this->getDefault(["identity" => "1234567890", "dependency" => "1234567890"]);

        return $this->post($query);;
    }

    private function createIdentityDependencyIsolate(): array
    {
        $query = $this->getDefault();

        return $this->post($query);
    }
}
