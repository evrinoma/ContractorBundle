<?php

namespace Evrinoma\ContractorBundle\DependencyInjection\Compiler;


use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Evrinoma\ContractorBundle\DependencyInjection\ContractorExtension;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass implements CompilerPassInterface
{
//region SECTION: Fields
    private string $nameSpace;
    private string $path;
//endregion Fields
//region SECTION: Constructor
    /**
     * MapEntityPass constructor.
     *
     * @param string $nameSpace
     */
    public function __construct(string $nameSpace, string $path)
    {
        $this->nameSpace = $nameSpace;
        $this->path = $path;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {

        $driver = $container->findDefinition('doctrine.orm.default_metadata_driver');
        $referenceAnnotationReader = new Reference('annotations.reader');

        $definitionAnnotationDriver = new Definition(AnnotationDriver::class, [$referenceAnnotationReader, sprintf('%s/Model', $this->path)]);
        $driver->addMethodCall('addDriver', [$definitionAnnotationDriver,sprintf('%s\Model', $this->nameSpace)]);

        if ($container->getParameter('evrinoma.contractor.class') === ContractorExtension::ENTITY_BASE_CONTRACTOR) {

            $definitionAnnotationDriver = new Definition(AnnotationDriver::class, [$referenceAnnotationReader, sprintf('%s/Entity', $this->path)]);
            $driver->addMethodCall('addDriver', [$definitionAnnotationDriver,sprintf('%s\Entity', $this->nameSpace)]);

            return;
        }
    }
}