<?php


namespace Evrinoma\ContractorBundle\DependencyInjection;

use Evrinoma\ContractorBundle\ContractorBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Evrinoma\ContractorBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
//region SECTION: Getters/Setters
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder      = new TreeBuilder(ContractorBundle::CONTRACTOR_BUNDLE);
        $rootNode         = $treeBuilder->getRootNode();
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('split')->cannotBeEmpty()->defaultFalse()->info('This option is used for enable/disable split entity strategy on particular or different')->end()
            ->scalarNode('factory')->cannotBeEmpty()->defaultValue(ContractorExtension::ENTITY_FACTORY)->end()
            ->scalarNode('entity')->cannotBeEmpty()->defaultValue(ContractorExtension::ENTITY_BASE_CONTRACTOR)->end()
            ->scalarNode('entity_person')->cannotBeEmpty()->defaultValue(ContractorExtension::ENTITY_SPLIT_CONTRACTOR_PERSON)->end()
            ->scalarNode('entity_company')->cannotBeEmpty()->defaultValue(ContractorExtension::ENTITY_SPLIT_CONTRACTOR_COMPANY)->end()
            ->scalarNode('constraints')->defaultTrue()->info('This option is used for enable/disable basic constraints')->end()
            ->scalarNode('dto')->defaultNull()->info('This option is used for dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used for command decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used for query decoration')->end()
            ->end()->end()->end();

        return $treeBuilder;
    }
//endregion Getters/Setters
}
