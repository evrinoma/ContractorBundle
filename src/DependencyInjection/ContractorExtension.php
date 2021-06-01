<?php


namespace Evrinoma\ContractorBundle\DependencyInjection;

use Evrinoma\ContractorBundle\ContractorBundle;
use Evrinoma\ContractorBundle\DependencyInjection\Compiler\ConstraintPass;
use Evrinoma\ContractorBundle\Dto\ContractorApiDto;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ContractorExtension
 *
 * @package Evrinoma\ContractorBundle\DependencyInjection
 */
class ContractorExtension extends Extension
{
//region SECTION: Fields
    public const ENTITY_BASE_CONTRACTOR = 'Evrinoma\ContractorBundle\Entity\BaseContractor';
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
        $definitionApiController->setArgument(5, $config['dto_class'] ?? ContractorApiDto::class);

        $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.factory');
        $definitionFactory->setArgument(0, $config['class']);

        $definitionValidator= $container->getDefinition('evrinoma.'.$this->getAlias().'.validator');
        $definitionValidator->setArgument(0, $config['class']);

        $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.repository');

        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.'.$this->getAlias().'.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));

            $definitionRepository->setArgument(0, new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry'));
            $definitionRepository->setArgument(1, $config['class']);

            $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);

            $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.object_manager');
            $definitionRepository->setFactory([new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry'), 'getManager']);
        }

        if ($config['constraints']) {
            $loader->load('validation.yml');
            foreach ($container->getDefinitions() as $key => $definition)
            {
                if (strpos($key, ConstraintPass::CONTRACTOR_CONSTRAINT) !== false)
                {
                    $definition->addTag(ConstraintPass::CONTRACTOR_CONSTRAINT);
                }
            }
        }

        $this->remapParametersNamespaces(
            $config,
            $container,
            [
                '' => [
                    'db_driver'           => 'evrinoma.'.$this->getAlias().'.storage',
                    'class'               => 'evrinoma.'.$this->getAlias().'.class',
                    'entity_manager_name' => 'evrinoma.'.$this->getAlias().'.entity_manager_name',
                ],
            ]
        );
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return ContractorBundle::CONTRACTOR_BUNDLE;
    }
//endregion Getters/Setters
}