<?php


namespace Evrinoma\ContractorBundle\Validator;


use Evrinoma\ContractorBundle\Entity\Basic\BaseContractor;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;

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
     * ContractorValidator constructor.
     *
     * @param string $entityClass
     */
    public function __construct(string $entityClass)
    {
        parent::__construct($entityClass);
    }
//endregion Constructor
}