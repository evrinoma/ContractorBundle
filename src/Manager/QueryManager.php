<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Exception\ContractorProxyException;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;
use Evrinoma\ContractorBundle\Repository\ContractorQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;


final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private ContractorQueryRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(ContractorQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Public
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
//endregion Public

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
            $contractor = $this->repository->find($dto->getId());
        } catch (ContractorNotFoundException $e) {
            throw $e;
        }

        return $contractor;
    }

    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @return ContractorInterface
     * @throws ContractorProxyException
     */
    public function proxy(ContractorApiDtoInterface $dto): ContractorInterface
    {
        try {
            if ($dto->hasId()) {
                $contractor = $this->repository->proxy($dto->getId());
            } else {
                throw new ContractorProxyException("Id value is not set while trying get proxy object");
            }
        } catch (ContractorProxyException $e) {
            throw $e;
        }

        return $contractor;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}