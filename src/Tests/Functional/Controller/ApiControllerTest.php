<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Controller;


use Evrinoma\ContractorBundle\Dto\ContractorApiDto;
use Evrinoma\ContractorBundle\Tests\Functional\Helper\BaseContractorTestTrait;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestTrait;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestTrait;
use Evrinoma\TestUtilsBundle\Helper\ResponseStatusTestTrait;
use Evrinoma\TestUtilsBundle\Web\AbstractWebCaseTest;
use Evrinoma\UtilsBundle\Model\ActiveModel;

/**
 * @group functional
 */
class ApiControllerTest extends AbstractWebCaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiMethodTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/contractor';
    public const API_CRITERIA = 'evrinoma/api/contractor/criteria';
    public const API_DELETE   = 'evrinoma/api/contractor/delete';
    public const API_PUT      = 'evrinoma/api/contractor/save';
    public const API_POST     = 'evrinoma/api/contractor/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiMethodTestTrait, ResponseStatusTestTrait, BaseContractorTestTrait;

//region SECTION: Protected
//endregion Protected

//region SECTION: Public
    public static function defaultData(): array
    {
        return [
            "name"       => "test company",
            "id"         => static::id(),
            "active"     => ActiveModel::ACTIVE,
            "created_at" => "2021-06-08 17:46",
            "class"      => static::getDtoClass(),
        ];
    }

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

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => static::identity()]);
        $this->testResponseStatusOK();
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => static::identityMd5($query['name'])]);
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

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => static::wrongIdentity()]);
        $this->testResponseStatusNotFound();
        $this->assertArrayHasKey('data', $response);
    }

    public function testPut(): void
    {
        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $find = $this->get(static::id());
        $this->testResponseStatusOK();

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertCount(0, array_diff($created['data'], $find['data']));

        $query = [
            "class"    => static::getDtoClass(),
            "id"       => $find['data']['id'],
            "identity" => static::wrongIdentity(),
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
            "id"       => static::id(),
            "identity" => static::wrongIdentity(),
            "active"   => ActiveModel::BLOCKED,
        ];

        $this->put($query);
        $this->testResponseStatusNotFound();
    }

    public function testPutUnprocessable(): void
    {
        $query = [
            "class"    => static::getDtoClass(),
            "id"       => static::emptyId(),
            "identity" => static::wrongIdentity(),
            "active"   => ActiveModel::BLOCKED,
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $query = [
            "id"       => static::id(),
            "identity" => static::wrongIdentity(),
            "active"   => ActiveModel::BLOCKED,
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function testDelete(): void
    {
        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $find = $this->get(static::id());
        $this->testResponseStatusOK();

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $response = $this->delete(static::id());
        $this->testResponseStatusAccepted();

        $delete = $this->get(static::id());

        $this->assertArrayHasKey('data', $delete);
        $this->assertArrayHasKey('data', $response);

        $this->assertCount(1, array_diff($find['data'], $delete['data']));
        $this->assertEquals(ActiveModel::DELETED, $delete['data']['active']);
    }

    public function testDeleteNotFound(): void
    {
        $response = $this->delete(static::id());
        $this->assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function testDeleteUnprocessable(): void
    {
        $response = $this->delete(static::emptyId());
        $this->assertArrayHasKey('data', $response);
        $this->testResponseStatusUnprocessable();
    }

    public function testGet(): void
    {
        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $find = $this->get(static::id());
        $this->testResponseStatusOK();

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertCount(0, array_diff($created['data'], $find['data']));
    }

    public function testGetNotFound(): void
    {
        $response = $this->get(static::id());
        $this->assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function testPostIdentity(): void
    {
        $this->createIdentity();

        $this->testResponseStatusCreated();
    }

    public function testPostIdentityDependency(): void
    {
        $this->createIdentityDependency();

        $this->testResponseStatusCreated();
    }

    public function testPostIdentityDependencyIsolate(): void
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
//region SECTION: Getters/Setters
    public static function getFixtures(): array
    {
        return [];
    }

    public static function getDtoClass(): string
    {
        return ContractorApiDto::class;
    }
//endregion Getters/Setters
}
