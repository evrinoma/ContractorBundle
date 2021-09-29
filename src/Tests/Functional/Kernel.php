<?php

namespace Evrinoma\ContractorBundle\Tests\Functional;

use Evrinoma\TestUtilsBundle\Kernel\AbstractApiKernel;

/**
 * Kernel
 */
class Kernel extends AbstractApiKernel
{
//region SECTION: Fields
    protected string $bundlePrefix = 'ContractorBundle';
    protected string $rootDir = __DIR__;
//endregion Fields

//region SECTION: Public
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return array_merge(parent::registerBundles(), [new \Evrinoma\DtoBundle\EvrinomaDtoBundle(), new \Evrinoma\ContractorBundle\EvrinomaContractorBundle()]);
    }

    protected function getBundleConfig(): array
    {
        return  ['framework.yaml', 'jms_serializer.yaml'];
    }

}
