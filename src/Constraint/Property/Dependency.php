<?php


namespace Evrinoma\ContractorBundle\Constraint\Property;

use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;
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