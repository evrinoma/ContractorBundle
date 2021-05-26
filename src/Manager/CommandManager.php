<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeRemovedException;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeSavedException;
use Evrinoma\ContractorBundle\Exception\ContractorInvalidException;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Factory\ContractorFactoryInterface;
use Evrinoma\ContractorBundle\Repository\ContractorRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommandManager implements CommandManagerInterface
{
    use RestTrait;

//region SECTION: Fields
    private ValidatorInterface            $validator;
    private ContractorRepositoryInterface $repository;
    private ContractorFactoryInterface    $factory;
//endregion Fields

//region SECTION: Constructor
    public function __construct(ValidatorInterface $validator, ContractorRepositoryInterface $repository, ContractorFactoryInterface $factory)
    {
        $this->validator  = $validator;
        $this->repository = $repository;
        $this->factory    = $factory;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @throws ContractorInvalidException
     */
    public function put(ContractorApiDtoInterface $dto): void
    {
        try {
            $contractor = $this->repository->find($dto->getEntityId());
        } catch (ContractorNotFoundException $e) {
            throw $e;
        }

        $contractor
            ->setInn($dto->getInn())
            ->setInn($dto->getInn())
            ->setFullName($dto->getFullName())
            ->setShortName($dto->getShortName())
            ->setUpdatedAt(new \DateTime());

        if ($this->validator->validate($contractor)) {
            throw new ContractorInvalidException("Can't update, contractor is invalid cause wrong DTO");
        }

        $this->repository->save($contractor);
    }

    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @throws ContractorCannotBeRemovedException
     * @throws ContractorNotFoundException
     */
    public function delete(ContractorApiDtoInterface $dto): void
    {
        try {
            $contractor = $this->repository->find($dto->getEntityId());
        } catch (ContractorNotFoundException $e) {
            throw $e;
        }
        try {
            $this->repository->remove($contractor);
        } catch (ContractorCannotBeRemovedException $e) {
            throw $e;
        }
    }

    /**
     * @param ContractorApiDtoInterface $dto
     *
     * @throws ContractorInvalidException
     * @throws ContractorCannotBeSavedException
     */
    public function post(ContractorApiDtoInterface $dto): void
    {
        $contractor = $this->factory->create($dto);

        if ($this->validator->validate($contractor)) {
            throw new ContractorInvalidException("Can't create, contractor is invalid cause wrong DTO");
        }

        $this->repository->save($contractor);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}