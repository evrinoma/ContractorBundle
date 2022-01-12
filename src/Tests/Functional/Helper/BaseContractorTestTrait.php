<?php

namespace Evrinoma\ContractorBundle\Tests\Functional\Helper;


use Evrinoma\ContractorBundle\Tests\Functional\ValueObject\Dependency;
use Evrinoma\ContractorBundle\Tests\Functional\ValueObject\Id;
use Evrinoma\ContractorBundle\Tests\Functional\ValueObject\Identity;
use Evrinoma\ContractorBundle\Tests\Functional\ValueObject\Name;

trait BaseContractorTestTrait
{
//region SECTION: Protected
    protected function createIdentity(array $extend = [], array $override = []): array
    {
        $query = static::merge(["identity" => Identity::value(),], $extend);

        return $this->post(static::getDefault($override ?: $query));
    }

    protected function createIdentityDependency(array $extend = [], array $override = []): array
    {
        $query = static::merge(["identity" => Identity::value(), "dependency" => Dependency::value()], $extend);

        return $this->post(static::getDefault($override ?: $query));
    }

    protected function createIdentityDependencyIsolate(array $extend = [], array $override = []): array
    {
        $query = static::getDefault($extend);

        return $this->post(static::getDefault($override ?: $query));
    }

    protected static function identityMd5($value): string
    {
        return md5($value);
    }

//endregion Protected
}