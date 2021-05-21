<?php


namespace Evrinoma\ContractorBundle;


use Evrinoma\ContractorBundle\DependencyInjection\ContractorExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;


/**
 * Class ContractorBundle
 *
 * @package Evrinoma\ContractorBundle
 */
class ContractorBundle extends Bundle
{
    public const CONTRACTOR_BUNDLE = 'contractor';

//region SECTION: Getters/Setters
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new ContractorExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters
}