<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Helper;


use Evrinoma\ContractorBundle\Tests\Functional\Helper\ValueObject\Dependency;
use Evrinoma\ContractorBundle\Tests\Functional\Helper\ValueObject\Id;
use Evrinoma\ContractorBundle\Tests\Functional\Helper\ValueObject\Identity;
use Evrinoma\ContractorBundle\Tests\Functional\Helper\ValueObject\Name;

trait BaseContractorTestTrait
{
//region SECTION: Protected
    protected function createIdentity(array $extend = [], array $override = []): array
    {
        $query = static::merge(["identity" => static::identity(),], $extend);

        return $this->post(static::getDefault($override ?: $query));
    }

    protected function createIdentityDependency(array $extend = [], array $override = []): array
    {
        $query = static::merge(["identity" => static::identity(), "dependency" => static::dependency()], $extend);

        return $this->post(static::getDefault($override ?: $query));
    }

    protected function createIdentityDependencyIsolate(array $extend = [], array $override = []): array
    {
        $query = static::getDefault($extend);

        return $this->post(static::getDefault($override ?: $query));
    }

    protected static function identity(): string
    {
        return Identity::value();
    }

    protected static function emptyIdentity(): string
    {
        return Identity::empty();
    }

    protected static function wrongIdentity(): string
    {
        return Identity::wrong();
    }

    protected static function identityMd5($value): string
    {
        return md5($value);
    }

    protected static function dependency(): string
    {
        return Dependency::value();
    }

    protected static function emptyDependency(): string
    {
        return Dependency::empty();
    }

    protected static function wrongDependency(): string
    {
        return Dependency::wrong();
    }

    protected static function id(): string
    {
        return Id::value();
    }

    protected static function emptyId(): string
    {
        return Id::empty();
    }

    protected static function wrongId(): string
    {
        return Id::wrong();
    }

    protected static function nullableId(): string
    {
        return Id::nullable();
    }

    protected static function name(): string
    {
        return Name::value();
    }

    protected static function emptyName(): string
    {
        return Name::empty();
    }

    protected static function wrongName(): string
    {
        return Name::wrong();
    }
//endregion Protected

}