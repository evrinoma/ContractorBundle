<?php

namespace Evrinoma\ContractorBundle\Factory;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Entity\Basic\BaseContractor;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;

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
    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @return ContractorInterface
     */
    public function create(ContractorApiDtoInterface $dto): ContractorInterface
    {
        /** @var BaseContractor $contractor */
        $contractor = new self::$entityClass;

        $contractor
            ->setIdentity(trim($dto->getIdentity()))
            ->setDependency(trim($dto->getDependency()))
            ->setName(trim($dto->getName()))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        return $contractor;
    }
//endregion Public
}