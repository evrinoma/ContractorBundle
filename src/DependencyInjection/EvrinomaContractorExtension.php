<?php


namespace Evrinoma\ContractorBundle\DependencyInjection;

use Evrinoma\ContractorBundle\EvrinomaContractorBundle;
use Evrinoma\ContractorBundle\DependencyInjection\Compiler\ConstraintPass;
use Evrinoma\ContractorBundle\Dto\ContractorApiDto;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class EvrinomaContractorExtension extends Extension
{
//region SECTION: Fields
    public const ENTITY_FACTORY                  = 'Evrinoma\ContractorBundle\Factory\ContractorFactory';
    public const ENTITY_BASE_CONTRACTOR          = 'Evrinoma\ContractorBundle\Entity\Basic\BaseContractor';
    public const ENTITY_SPLIT_CONTRACTOR         = 'Evrinoma\ContractorBundle\Entity\Split\BaseContractor';
    public const ENTITY_SPLIT_CONTRACTOR_PERSON  = 'Evrinoma\ContractorBundle\Entity\Split\BaseContractorPerson';
    public const ENTITY_SPLIT_CONTRACTOR_COMPANY = 'Evrinoma\ContractorBundle\Entity\Split\BaseContractorCompany';

    /**
     * @var array
     */
    private static array $doctrineDrivers = array(
        'orm' => array(
            'registry' => 'doctrine',
            'tag'      => 'doctrine.event_subscriber',
        ),
    );
//endregion Fields

//region SECTION: Protected
    protected function remapParameters(array $config, ContainerBuilder $container, array $map): void
    {
        foreach ($map as $name => $paramName) {
            if (array_key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces): void
    {
        foreach ($namespaces as $ns => $map) {
            if ($ns) {
                if (!array_key_exists($ns, $config)) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }
            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    $container->setParameter(sprintf($map, $name), $value);
                }
            }
        }
    }
//endregion Protected

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.api.controller');
        $definitionApiController->setArgument(5, $config['dto'] ?? ContractorApiDto::class);

        if ($config['factory'] !== self::ENTITY_FACTORY) {
            $container->removeDefinition('evrinoma.'.$this->getAlias().'.factory');
            $definitionFactory = new Definition($config['factory']);
            $alias = new Alias('evrinoma.'.$this->getAlias().'.factory');
            $container->addDefinitions([ 'evrinoma.'.$this->getAlias().'.factory' => $definitionFactory]);
            $container->addAliases([$config['factory'] => $alias]);
        }

        $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.factory');
        $definitionFactory->setArgument(0, $config['entity']);

        $definitionValidator = $container->getDefinition('evrinoma.'.$this->getAlias().'.validator');
        $definitionValidator->setArgument(0, $config['entity']);

        $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.repository');

        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.'.$this->getAlias().'.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));

            $definitionQueryMediator = $container->getDefinition('evrinoma.'.$this->getAlias().'.query.mediator');

            $definitionRepository->setArgument(0, new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry'));
            $definitionRepository->setArgument(1, $config['entity']);
            $definitionRepository->setArgument(2, $definitionQueryMediator);

            $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);

            $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.object_manager');
            $definitionRepository->setFactory([new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry'), 'getManager']);
        }

        if ($config['constraints']) {
            $loader->load('validation.yml');
            foreach ($container->getDefinitions() as $key => $definition) {
                if (strpos($key, ConstraintPass::CONTRACTOR_CONSTRAINT) !== false) {
                    $definition->addTag(ConstraintPass::CONTRACTOR_CONSTRAINT);
                }
            }
        }

        $this->remapParametersNamespaces(
            $config,
            $container,
            [
                '' => [
                    'db_driver' => 'evrinoma.'.$this->getAlias().'.storage',
                    'split'     => 'evrinoma.'.$this->getAlias().'.split',
                    'entity'    => 'evrinoma.'.$this->getAlias().'.entity',
                ],
            ]
        );

        if ($config['split']) {
            $this->remapParametersNamespaces(
                $config,
                $container,
                [
                    '' => [
                        'entity_person'  => 'evrinoma.'.$this->getAlias().'.entity_person',
                        'entity_company' => 'evrinoma.'.$this->getAlias().'.entity_company',
                    ],
                ]
            );
        }

        if ($config['decorates']) {
            $this->remapParametersNamespaces(
                $config['decorates'],
                $container,
                [
                    '' => [
                        'command'  => 'evrinoma.'.$this->getAlias().'.decorates.command',
                        'query' => 'evrinoma.'.$this->getAlias().'.decorates.query',
                    ],
                ]
            );
        }
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaContractorBundle::CONTRACTOR_BUNDLE;
    }
//endregion Getters/Setters
}