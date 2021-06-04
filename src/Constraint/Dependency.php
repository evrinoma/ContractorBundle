<?php


namespace Evrinoma\ContractorBundle\Constraint;

use Symfony\Component\Validator\Constraints\NotBlank;

class Dependency implements ConstraintInterface
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
        return 'name';
    }
//endregion Getters/Setters
}