<?php


namespace Evrinoma\ContractorBundle\Constraint;

use Symfony\Component\Validator\Constraints\NotBlank;

class FullName implements ConstraintInterface
{
//region SECTION: Getters/Setters
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
        ];
    }

    public function getPropertyName(): string
    {
        return 'fullName';
    }
//endregion Getters/Setters
}