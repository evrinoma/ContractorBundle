<?php

namespace Evrinoma\ContractorBundle\Validator;

use Evrinoma\ContractorBundle\Constraint\ConstraintInterface;

interface ContractorValidatorInterface
{
    public function validate($value, $constraints = null, $groups = null);
    public function addConstraint(ConstraintInterface $constant):void;
}