<?php

namespace Evrinoma\ContractorBundle\Factory;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Entity\BaseContractor;
use Evrinoma\ContractorBundle\Model\ContractorInterface;

class ContractorFactory implements ContractorFactoryInterface
{
//region SECTION: Fields
    private static string $entityClass = BaseContractor::class;
//endregion Fields

//region SECTION: Constructor
    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }
//endregion Constructor

//region SECTION: Public
    public function create(ContractorApiDtoInterface $dto): ContractorInterface
    {
        /** @var BaseContractor $contractor */
        $contractor = new self::$entityClass;

        $contractor
            ->setInn($dto->getInn())
            ->setFullName($dto->getFullName())
            ->setShortName($dto->getShortName())
            ->setCreatedAt(new \DateTime())
            ->setActiveToActive();

        return $contractor;
    }
//endregion Public
}