<?php


namespace Evrinoma\ContractorBundle\Constraint;

use Symfony\Component\Validator\Constraints\NotBlank;

class ShortName implements ConstraintInterface
{
    public function getConstraints(): array
    {
        return [
            new NotBlank()
        ];
    }

    public function getPropertyName(): string
    {
        return 'shortName';
    }
}