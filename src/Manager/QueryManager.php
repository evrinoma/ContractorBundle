<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Model\ContractorInterface;
use Evrinoma\ContractorBundle\Repository\ContractorRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

class QueryManager implements QueryManagerInterface
{
    use RestTrait;

//region SECTION: Fields
    private ContractorRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(ContractorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Getters/Setters
    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @return ContractorInterface
     * @throws ContractorNotFoundException
     */
    public function get(ContractorApiDtoInterface $dto): ContractorInterface
    {
        try {
            $contractor = $this->repository->find($dto->getEntityId());
        } catch (ContractorNotFoundException $e) {
            throw $e;
        }

        return $contractor;
    }

    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @return ContractorInterface[]
     * @throws ContractorNotFoundException
     */
    public function criteria(ContractorApiDtoInterface $dto): array
    {
        try {
            $contractors = $this->repository->findByCriteria($dto);
        } catch (ContractorNotFoundException $e) {
            throw $e;
        }

        return $contractors;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}