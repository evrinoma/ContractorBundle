<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Action;

use Evrinoma\ContractorBundle\Dto\ContractorApiDto;
use Evrinoma\ContractorBundle\Tests\Functional\Helper\BaseContractorTestTrait;
use Evrinoma\ContractorBundle\Tests\Functional\ValueObject\Id;
use Evrinoma\ContractorBundle\Tests\Functional\ValueObject\Identity;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use PHPUnit\Framework\Assert;

class BaseContractor extends AbstractServiceTest implements BaseContractorTestInterface
{
    use BaseContractorTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/contractor';
    public const API_CRITERIA = 'evrinoma/api/contractor/criteria';
    public const API_DELETE   = 'evrinoma/api/contractor/delete';
    public const API_PUT      = 'evrinoma/api/contractor/save';
    public const API_POST     = 'evrinoma/api/contractor/create';
//endregion Fields

//region SECTION: Protected
    protected static function getDtoClass(): string
    {
        return ContractorApiDto::class;
    }

    protected static function defaultData(): array
    {
        return [
            "name"       => "test company",
            "id"         => Id::value(),
            "active"     => ActiveModel::ACTIVE,
            "created_at" => "2021-06-08 17:46",
            "class"      => static::getDtoClass(),
        ];
    }
//endregion Protected

//region SECTION: Public
    public function actionPost(): void
    {
        $this->createIdentity();
        $this->testResponseStatusCreated();
        $this->createIdentityDependency();
        $this->testResponseStatusCreated();
        $this->createIdentityDependencyIsolate();
        $this->testResponseStatusCreated();
    }

    public function actionCriteria(): void
    {
        $query = static::getDefault();

        $this->createIdentity();
        $this->testResponseStatusCreated();
        $this->createIdentityDependency();
        $this->testResponseStatusCreated();
        $this->createIdentityDependencyIsolate();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => Identity::value()]);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(2, $response['data']);

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => static::identityMd5($query['name'])]);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);
    }

    public function actionCriteriaNotFound(): void
    {
        $this->createIdentity();
        $this->testResponseStatusCreated();
        $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "identity" => Identity::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey('data', $response);
    }

    public function actionPut(): void
    {
        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $find = $this->get(Id::value());
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        Assert::assertTrue($created['data'] == $find['data']);

        $query = [
            "class"    => static::getDtoClass(),
            "id"       => $find['data']['id'],
            "identity" => Identity::wrong(),
            "active"   => ActiveModel::BLOCKED,
            "name"     => $find['data']['name'],
        ];

        $this->put($query);
        $this->testResponseStatusOK();
    }

    public function actionPutNotFound(): void
    {
        $query = [
            "class"    => static::getDtoClass(),
            "id"       => Id::value(),
            "identity" => Identity::wrong(),
            "active"   => ActiveModel::BLOCKED,
        ];

        $this->put($query);
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $query = [
            "class"    => static::getDtoClass(),
            "id"       => Id::empty(),
            "identity" => Identity::wrong(),
            "active"   => ActiveModel::BLOCKED,
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $query = [
            "id"       => Id::value(),
            "identity" => Identity::wrong(),
            "active"   => ActiveModel::BLOCKED,
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionDelete(): void
    {
        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $find = $this->get(Id::value());
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        $response = $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->get(Id::value());

        Assert::assertArrayHasKey('data', $delete);
        Assert::assertArrayHasKey('data', $response);

        Assert::assertEquals(ActiveModel::DELETED, $delete['data']['active']);
        unset($find['data']['active']);
        unset($delete['data']['active']);
        Assert::assertTrue($find['data'] == $delete['data']);
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::value());
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $response = $this->delete(Id::empty());
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusUnprocessable();
    }

    public function actionGet(): void
    {
        $created = $this->createIdentityDependency();
        $this->testResponseStatusCreated();

        $find = $this->get(Id::value());
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        Assert::assertTrue($created['data'] == $find['data']);
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::value());
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function actionPostIdentity(): void
    {
        $this->createIdentity();

        $this->testResponseStatusCreated();
    }

    public function actionPostIdentityDependency(): void
    {
        $this->createIdentityDependency();

        $this->testResponseStatusCreated();
    }

    public function actionPostIdentityDependencyIsolate(): void
    {
        $this->createIdentityDependencyIsolate();

        $this->testResponseStatusCreated();
    }

    public function actionPostDuplicate(): void
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

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();

        $this->testResponseStatusUnprocessable();
    }
//endregion Public
}