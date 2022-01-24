<?php


namespace Evrinoma\ContractorBundle\Constraint\Property;

use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class Identity implements ConstraintInterface
{
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
        ];
    }

    public function getPropertyName(): string
    {
        return 'identity';
    }
}