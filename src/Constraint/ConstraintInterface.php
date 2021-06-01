<?php

namespace Evrinoma\ContractorBundle\Constraint;

interface ConstraintInterface
{
    public function getConstraints(): array;
    public function getPropertyName():string;
}