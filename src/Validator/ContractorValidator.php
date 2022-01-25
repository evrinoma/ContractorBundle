<?php


namespace Evrinoma\ContractorBundle\Validator;


use Evrinoma\ContractorBundle\Entity\Basic\BaseContractor;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ContractorValidator extends AbstractValidator
{
//region SECTION: Fields
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseContractor::class;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ValidatorInterface $validator
     * @param string             $entityClass
     */
    public function __construct(ValidatorInterface $validator, string $entityClass)
    {
        parent::__construct($validator, $entityClass);
    }
//endregion Constructor
}