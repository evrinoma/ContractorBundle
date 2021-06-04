<?php


namespace Evrinoma\ContractorBundle\Constraint;


use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Identity implements ConstraintInterface
{
    public function getConstraints(): array
    {
        return [
            new NotBlank()
        ];
    }

    public function getPropertyName(): string
    {
        return 'identity';
    }
}