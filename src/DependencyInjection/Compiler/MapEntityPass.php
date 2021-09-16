<?php

namespace Evrinoma\ContractorBundle\DependencyInjection\Compiler;


use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Evrinoma\ContractorBundle\DependencyInjection\EvrinomaContractorExtension;
use Evrinoma\ContractorBundle\Model\Split\ContractorCompanyInterface;
use Evrinoma\ContractorBundle\Model\Split\ContractorPersonInterface;
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
        $this->path      = $path;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        /**
         * добавляем переопредеям мапинг, если используется базовая сущность бандла, в зависимости от конфигурации
         * если базовая сущность была переопределенна, то удаляем мапинг
         */
        $driver                    = $container->findDefinition('doctrine.orm.default_metadata_driver');
        $referenceAnnotationReader = new Reference('annotations.reader');

        $entity = $container->getParameter('evrinoma.contractor.entity');
        if (strpos(EvrinomaContractorExtension::ENTITY, $entity)) {

            $isSplit = $container->getParameter('evrinoma.contractor.split');

            if ($isSplit) {
                $this->loadMetadata($container, $driver, $referenceAnnotationReader, '%s/Model/Split', '%s/Entity/Split');

                $resolveTargetEntity = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');
                $resolveTargetEntity->addMethodCall('addResolveTargetEntity', [ContractorPersonInterface::class, $container->getParameter('evrinoma.contractor.entity_person'), []]);
                $resolveTargetEntity->addMethodCall('addResolveTargetEntity', [ContractorCompanyInterface::class, $container->getParameter('evrinoma.contractor.entity_company'), []]);

                $eventManager = $container->findDefinition('doctrine.dbal.connection.event_manager');
                $eventManager->addMethodCall('addEventListener', [Events::loadClassMetadata, new Reference('doctrine.orm.listeners.resolve_target_entity')]);
                $this->remapEntity($driver, 'Split');

                throw new \Exception('This functionality unsupported');
            } else {
                $this->loadMetadata($container, $driver, $referenceAnnotationReader, '%s/Model/Basic', '%s/Entity/Basic');
                $this->remapEntity($driver, 'Basic');
            }
        } else {
            $this->cleanMetadata($driver, [EvrinomaContractorExtension::ENTITY]);
        }
    }

//region SECTION: Private
    private function cleanMetadata(Definition $driver, array $namesSpaces)
    {
        $calls = [];
        foreach ($driver->getMethodCalls() as $i => $call) {
            if ($call[1][1] && in_array($call[1][1], $namesSpaces)) {
                continue;
            }
            $calls[] = $call;
        }
        $driver->setMethodCalls($calls);
    }

    private function loadMetadata(ContainerBuilder $container, Definition $driver, Reference $referenceAnnotationReader, $formatterModel, $formatterEntity): void
    {
        $definitionAnnotationDriver = new Definition(AnnotationDriver::class, [$referenceAnnotationReader, sprintf($formatterModel, $this->path)]);
        $driver->addMethodCall('addDriver', [$definitionAnnotationDriver, sprintf(str_replace('/', '\\', $formatterModel), $this->nameSpace)]);

        if (in_array($container->getParameter('evrinoma.contractor.entity'), [EvrinomaContractorExtension::ENTITY_BASE_CONTRACTOR, EvrinomaContractorExtension::ENTITY_SPLIT_CONTRACTOR], true)) {
            $definitionAnnotationDriver = new Definition(AnnotationDriver::class, [$referenceAnnotationReader, sprintf($formatterEntity, $this->path)]);
            $driver->addMethodCall('addDriver', [$definitionAnnotationDriver, sprintf(str_replace('/', '\\', $formatterEntity), $this->nameSpace)]);
        }
    }

    private function remapEntity(Definition $driver, string $mapFolder): void
    {
        $calls = [];
        foreach ($driver->getMethodCalls() as $i => $call) {
            if ($call[1][1] && $call[1][1] === EvrinomaContractorExtension::ENTITY) {
                $call[1][1] = EvrinomaContractorExtension::ENTITY.'\\'.$mapFolder;
            }
            $calls[] = $call;
        }
        $driver->setMethodCalls($calls);
    }
//endregion Private
}