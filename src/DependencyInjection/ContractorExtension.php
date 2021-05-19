<?php


namespace Evrinoma\ContractorBundle\DependencyInjection;

use Evrinoma\ContractorBundle\ContractorBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class ContractorExtension
 *
 * @package Evrinoma\ContractorBundle\DependencyInjection
 */
class ContractorExtension extends Extension
{
//region SECTION: Fields
    private $container;
//endregion Fields

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $configuration   = $this->getConfiguration($configs, $container);
        $config          = $this->processConfiguration($configuration, $configs);
    }
//endregion Public


//region SECTION: Getters/Setters
    public function getAlias()
    {
        return ContractorBundle::CONTRACTOR_BUNDLE;
    }
//endregion Getters/Setters
}