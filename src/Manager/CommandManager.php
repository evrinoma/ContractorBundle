<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeRemovedException;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeSavedException;
use Evrinoma\ContractorBundle\Exception\ContractorInvalidException;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Factory\ContractorFactoryInterface;
use Evrinoma\ContractorBundle\Mediator\CommandMediatorInterface;
use Evrinoma\ContractorBundle\Repository\ContractorRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private ValidatorInterface            $validator;
    private ContractorRepositoryInterface $repository;
    private ContractorFactoryInterface    $factory;
    private CommandMediatorInterface      $mediator;
//endregion Fields

//region SECTION: Constructor
    /**
     * CommandManager constructor.
     *
     * @param ValidatorInterface            $validator
     * @param ContractorRepositoryInterface $repository
     * @param ContractorFactoryInterface    $factory
     * @param CommandMediatorInterface      $mediator
     */
    public function __construct(ValidatorInterface $validator, ContractorRepositoryInterface $repository, ContractorFactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator  = $validator;
        $this->repository = $repository;
        $this->factory    = $factory;
        $this->mediator   = $mediator;
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

        $this->mediator->onUpdate($dto, $contractor);

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
        $this->mediator->onDelete($dto, $contractor);
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

        $this->mediator->onCreate($dto, $contractor);

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