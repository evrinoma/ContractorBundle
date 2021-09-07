<?php


namespace Evrinoma\ContractorBundle;

use Evrinoma\ContractorBundle\DependencyInjection\Compiler\ConstraintPass;
use Evrinoma\ContractorBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\ContractorBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\ContractorBundle\DependencyInjection\EvrinomaContractorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;


/**
 * Class ContractorBundle
 *
 * @package Evrinoma\ContractorBundle
 */
class EvrinomaContractorBundle extends Bundle
{
//region SECTION: Fields
    public const CONTRACTOR_BUNDLE = 'contractor';
//endregion Fields

//region SECTION: Public
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new ConstraintPass())
        ;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaContractorExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters
}