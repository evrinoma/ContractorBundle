<?php


namespace Evrinoma\ContractorBundle\Constraint;


use Evrinoma\UtilsBundle\Model\ActiveModel;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class Active implements ConstraintInterface
{
//region SECTION: Getters/Setters
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
            new Choice([ActiveModel::ACTIVE, ActiveModel::DELETED, ActiveModel::BLOCKED]),
        ];
    }

    public function getPropertyName(): string
    {
        return 'active';
    }
//endregion Getters/Setters
}