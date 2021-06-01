<?php

namespace Evrinoma\ContractorBundle\DependencyInjection\Compiler;


use Evrinoma\ContractorBundle\ContractorBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DecoratorPass extends AbstractRecursivePass
{
//region SECTION: Public
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getExtensionConfig(ContractorBundle::CONTRACTOR_BUNDLE);
        $config = reset($config);
        if ($config['decorates']['query']) {
            $queryMediator = $container->getDefinition($config['decorates']['query']);
            $repository    = $container->getDefinition('evrinoma.'.ContractorBundle::CONTRACTOR_BUNDLE.'.repository');
            $repository->setArgument(2, $queryMediator);
        }

        if ($config['decorates']['command']) {
            $commandMediator = $container->getDefinition($config['decorates']['command']);
            $commandManager  = $container->getDefinition('evrinoma.'.ContractorBundle::CONTRACTOR_BUNDLE.'.command.manager');
            $commandManager->setArgument(3, $commandMediator);
        }
    }
}