<?php


namespace Evrinoma\ContractorBundle\Constraint;


use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Inn implements ConstraintInterface
{
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
            new Length(['max' => 10, 'min' => 10])
        ];
    }

    public function getPropertyName(): string
    {
        return 'inn';
    }
}