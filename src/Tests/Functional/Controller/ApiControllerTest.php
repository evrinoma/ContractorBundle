<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Controller;


use Evrinoma\ContractorBundle\Dto\ContractorApiDto;
use Evrinoma\ContractorBundle\Tests\Functional\CaseTest;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestTrait;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestTrait;
use Evrinoma\TestUtilsBundle\Helper\ResponseStatusTestTrait;
use Evrinoma\UtilsBundle\Model\ActiveModel;

/**
 * @group functional
 */
class ApiControllerTest extends CaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiMethodTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/contractor';
    public const API_CRITERIA = 'evrinoma/api/contractor/criteria';
    public const API_DELETE   = 'evrinoma/api/contractor/delete';
    public const API_PUT      = 'evrinoma/api/contractor/save';
    public const API_POST     = 'evrinoma/api/contractor/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiMethodTestTrait, ResponseStatusTestTrait;

//region SECTION: Protected
    public static function getFixtures(): array
    {
        return [];
    }

    public static function getDtoClass(): string
    {
        return ContractorApiDto::class;
    }

    public static function defaultData(): array
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
    public function testPost(): void
    {
        $this->createIdentity();
        $this->testResponseStatusCreated();
        $this->createIdentityDependency();
        $this->testResponseStatusCreated();
        $this->createIdentityDependencyIsolate();
        $this->testResponseStatusCreated();
    }

    public function testCriteria(): void
    {
        $query = static::getDefault();

        $this->createIdentity();
        $this->testResponseStatusCreated();
        $this->createIdentityDependency();
        $this->testResponseStatusCreated();
        $this->createIdentityDependencyIsolate();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => "1234567890"]);
        $this->testResponseStatusOK();
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => md5($query['name'])]);
        $this->testResponseStatusOK();
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(1, $response['data']);
    }

    public function testCriteriaNotFound(): void
    {
        $this->createIdentity();
        $this->testResponseStatusCreated();
        $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => "0987654321"]);
        $this->testResponseStatusNotFound();
        $this->assertArrayHasKey('data', $response);
    }

    public function testPut(): void
    {
        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

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
        $this->testResponseStatusOK();
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
        $this->testResponseStatusNotFound();
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
        $this->testResponseStatusUnprocessable();

        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $query = [
            "id"       => "1",
            "identity" => "0987654321",
            "active"   => ActiveModel::BLOCKED,
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function testDelete(): void
    {
        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $response = $this->delete('1');
        $this->testResponseStatusAccepted();

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
        $this->testResponseStatusNotFound();
    }

    public function testDeleteUnprocessable(): void
    {
        $response = $this->delete('');
        $this->assertArrayHasKey('data', $response);
        $this->testResponseStatusUnprocessable();
    }

    public function testGet(): void
    {
        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertCount(0, array_diff($created['data'], $find['data']));
    }

    public function testGetNotFound(): void
    {
        $response = $this->get(1);
        $this->assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function testPostIdentity(): void
    {
        $this->createIdentity();

        $this->testResponseStatusCreated();
    }

    public function testPostIdenityDependency(): void
    {
        $this->createIdentityDependency();

        $this->testResponseStatusCreated();
    }

    public function testPostIdenityDependencyIsolate(): void
    {
        $this->createIdentityDependencyIsolate();

        $this->testResponseStatusCreated();
    }

    public function testPostDuplicate(): void
    {
        $this->createIdentity();
        $this->testResponseStatusCreated();
        $this->createIdentityDependency();
        $this->testResponseStatusCreated();
        $this->createIdentityDependencyIsolate();
        $this->testResponseStatusCreated();

        $this->createIdentity();
        $this->testResponseStatusConflict();
        $this->createIdentityDependency();
        $this->testResponseStatusConflict();
        $this->createIdentityDependencyIsolate();
        $this->testResponseStatusConflict();
    }

    public function testPostUnprocessable(): void
    {
        $this->postWrong();

        $this->testResponseStatusUnprocessable();
    }
//endregion Public

//region SECTION: Private
    private function createIdentity(): array
    {
        $query = static::getDefault(["identity" => "1234567890",]);

        return $this->post($query);
    }

    private function createIdentityDependency(): array
    {
        $query = static::getDefault(["identity" => "1234567890", "dependency" => "1234567890"]);

        return $this->post($query);
    }

    private function createIdentityDependencyIsolate(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }
}
