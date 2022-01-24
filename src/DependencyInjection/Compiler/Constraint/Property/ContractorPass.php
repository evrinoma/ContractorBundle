<?php

namespace Evrinoma\ContractorBundle\DependencyInjection\Compiler\Constraint\Property;

use Evrinoma\ContractorBundle\Validator\ContractorValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class ContractorPass extends AbstractConstraint implements CompilerPassInterface
{
    public const CONTRACTOR_CONSTRAINT = 'evrinoma.contractor.constraint.property';

    protected static string $alias      = self::CONTRACTOR_CONSTRAINT;
    protected static string $class      = ContractorValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}