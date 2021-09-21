<?php


namespace Evrinoma\ContractorBundle\Constraint;

use Evrinoma\UtilsBundle\Constraint\ConstraintInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class Name implements ConstraintInterface
{
    public function getConstraints(): array
    {
        return [
            new NotBlank()
        ];
    }

    public function getPropertyName(): string
    {
        return 'name';
    }
}