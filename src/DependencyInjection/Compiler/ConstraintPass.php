<?php

namespace Evrinoma\ContractorBundle\DependencyInjection\Compiler;

use Evrinoma\ContractorBundle\Validator\ContractorValidator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class MenuItemPass
 *
 * @package Evrinoma\MenuBundle\DependencyInjection
 */
class ConstraintPass implements CompilerPassInterface
{
    public const CONTRACTOR_CONSTRAINT = 'evrinoma.contractor.constraint';

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ContractorValidator::class)) {
            return;
        }

        $definition = $container->findDefinition(ContractorValidator::class);

        $taggedServices = $container->findTaggedServiceIds(self::CONTRACTOR_CONSTRAINT);

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addConstraint', [new Reference($id)]);
        }
    }
}