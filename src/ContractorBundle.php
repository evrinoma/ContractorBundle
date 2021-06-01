<?php


namespace Evrinoma\ContractorBundle;

use Evrinoma\ContractorBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\ContractorBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\ContractorBundle\DependencyInjection\ContractorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;


/**
 * Class ContractorBundle
 *
 * @package Evrinoma\ContractorBundle
 */
class ContractorBundle extends Bundle
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
            ->addCompilerPass(new DecoratorPass());
    }
//endregion Public

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