<?php


namespace Evrinoma\ContractorBundle\DependencyInjection;

use Evrinoma\ContractorBundle\DependencyInjection\Compiler\Constraint\Property\ContractorPass;
use Evrinoma\ContractorBundle\Dto\ContractorApiDto;
use Evrinoma\ContractorBundle\EvrinomaContractorBundle;
use Evrinoma\UtilsBundle\DependencyInjection\HelperTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class EvrinomaContractorExtension extends Extension
{
    use HelperTrait;

//region SECTION: Fields
    public const FACTORY_CONTRACTOR              = 'Evrinoma\ContractorBundle\Factory\ContractorFactory';
    public const ENTITY                          = 'Evrinoma\ContractorBundle\Entity';
    public const ENTITY_BASE_CONTRACTOR          = self::ENTITY.'\Basic\BaseContractor';
    public const ENTITY_SPLIT_CONTRACTOR         = self::ENTITY.'\Split\BaseContractor';
    public const ENTITY_SPLIT_CONTRACTOR_PERSON  = self::ENTITY.'\Split\BaseContractorPerson';
    public const ENTITY_SPLIT_CONTRACTOR_COMPANY = self::ENTITY.'\Split\BaseContractorCompany';
    public const DTO_BASE_CONTRACTOR             = ContractorApiDto::class;

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

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ($container->getParameter('kernel.environment') === 'test') {
            $loader->load('tests.yml');
        }

        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        $this->wireController($container, $config['dto']);


        if ($config['factory'] !== self::FACTORY_CONTRACTOR) {
            $this->wireFactory($container, $config['factory'], $config['entity']);
        } else {
            $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.factory');
            $definitionFactory->setArgument(0, $config['entity']);
        }

        $this->wireValidator($container, $config['entity']);

        $doctrineRegistry = null;

        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.'.$this->getAlias().'.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));
            $doctrineRegistry = new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry');
            $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);
            $objectManager = $container->getDefinition('evrinoma.'.$this->getAlias().'.object_manager');
            $objectManager->setFactory([$doctrineRegistry, 'getManager']);
        }

        if ($doctrineRegistry) {
            $this->wireRepository($container, $doctrineRegistry, $config['entity']);
        }

        $loader->load('validation.yml');

        if ($config['constraints']) {
            $loader->load('constraint/contractor.yml');
        }

        $this->wireConstraintTag($container);

        $this->remapParametersNamespaces(
            $container,
            $config,
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
                $container,
                $config,
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
                $container,
                $config['decorates'],
                [
                    '' => [
                        'command' => 'evrinoma.'.$this->getAlias().'.decorates.command',
                        'query'   => 'evrinoma.'.$this->getAlias().'.decorates.query',
                    ],
                ]
            );
        }
    }

    private function wireConstraintTag(ContainerBuilder $container): void
    {
        foreach ($container->getDefinitions() as $key => $definition) {
            switch (true) {
                case strpos($key, ContractorPass::CONTRACTOR_CONSTRAINT) !== false :
                    $definition->addTag(ContractorPass::CONTRACTOR_CONSTRAINT);
                    break;
                default:
            }
        }
    }

    private function wireRepository(ContainerBuilder $container, Reference $doctrineRegistry, string $class): void
    {
        $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.repository');
        $definitionQueryMediator = $container->getDefinition('evrinoma.'.$this->getAlias().'.query.mediator');
        $definitionRepository->setArgument(0, $doctrineRegistry);
        $definitionRepository->setArgument(1, $class);
        $definitionRepository->setArgument(2, $definitionQueryMediator);
    }

    private function wireFactory(ContainerBuilder $container, string $class, string $paramClass): void
    {
        $container->removeDefinition('evrinoma.'.$this->getAlias().'.factory');
        $definitionFactory = new Definition($class);
        $definitionFactory->addArgument($paramClass);
        $alias = new Alias('evrinoma.'.$this->getAlias().'.factory');
        $container->addDefinitions(['evrinoma.'.$this->getAlias().'.factory' => $definitionFactory]);
        $container->addAliases([$class => $alias]);
    }

    private function wireController(ContainerBuilder $container, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.api.controller');
        $definitionApiController->setArgument(5, $class);
    }

    private function wireValidator(ContainerBuilder $container, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.validator');
        $definitionApiController->setArgument(0, new Reference('validator'));
        $definitionApiController->setArgument(1, $class);
    }

//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaContractorBundle::CONTRACTOR_BUNDLE;
    }
//endregion Getters/Setters
}