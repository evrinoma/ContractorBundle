<?php

namespace Evrinoma\ContractorBundle\DependencyInjection\Compiler;

use Evrinoma\ContractorBundle\Validator\ContractorValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class ConstraintPass
 *
 * @package Evrinoma\MenuBundle\DependencyInjection
 */
class ConstraintPass extends AbstractConstraint implements CompilerPassInterface
{
    public const CONTRACTOR_CONSTRAINT = 'evrinoma.contractor.constraint';

    protected static string $alias = self::CONTRACTOR_CONSTRAINT;
    protected static string $class = ContractorValidator::class;
    protected static string $methodCall = 'addConstraint';
}