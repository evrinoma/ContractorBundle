<?php

namespace Evrinoma\ContractorBundle\DependencyInjection\Compiler;


use Evrinoma\ContractorBundle\DependencyInjection\EvrinomaContractorExtension;
use Evrinoma\ContractorBundle\Model\Split\ContractorCompanyInterface;
use Evrinoma\ContractorBundle\Model\Split\ContractorPersonInterface;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Evrinoma\UtilsBundle\Exception\MapEntityCannotBeCompiledException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class PassMapEntity extends AbstractMapEntity implements CompilerPassInterface
{
//region SECTION: Public
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $this->setContainer($container);

        /**
         * добавляем переопредеям мапинг, если используется базовая сущность бандла, в зависимости от конфигурации
         * если базовая сущность была переопределенна, то удаляем мапинг
         */
        $driver                    = $container->findDefinition('doctrine.orm.default_metadata_driver');
        $referenceAnnotationReader = new Reference('annotations.reader');

        $entity = $container->getParameter('evrinoma.contractor.entity');
        if (strpos($entity, EvrinomaContractorExtension::ENTITY) !== false) {

            $isSplit = $container->getParameter('evrinoma.contractor.split');

            if ($isSplit) {
                $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Split', '%s/Entity/Split');

                $this->addResolveTargetEntity([
                    'evrinoma.contractor.entity_person'  => ContractorPersonInterface::class,
                    'evrinoma.contractor.entity_company' => ContractorCompanyInterface::class,
                ]);

                $this->remapMetadata($driver, 'Split');

                throw new MapEntityCannotBeCompiledException('This functionality unsupported yet');
            } else {
                $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Basic', '%s/Entity/Basic');
                $this->remapMetadata($driver, 'Basic');
            }
        } else {
            $this->cleanMetadata($driver, [EvrinomaContractorExtension::ENTITY]);
        }
    }
}