<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeRemovedException;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeSavedException;
use Evrinoma\ContractorBundle\Exception\ContractorInvalidException;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Factory\ContractorFactoryInterface;
use Evrinoma\ContractorBundle\Mediator\CommandMediatorInterface;
use Evrinoma\ContractorBundle\Model\ContractorInterface;
use Evrinoma\ContractorBundle\Repository\ContractorRepositoryInterface;
use Evrinoma\ContractorBundle\Validator\ContractorValidatorInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private ContractorValidatorInterface  $validator;
    private ContractorRepositoryInterface $repository;
    private ContractorFactoryInterface    $factory;
    private CommandMediatorInterface      $mediator;
//endregion Fields

//region SECTION: Constructor
    /**
     * CommandManager constructor.
     *
     * @param ContractorValidatorInterface  $validator
     * @param ContractorRepositoryInterface $repository
     * @param ContractorFactoryInterface    $factory
     * @param CommandMediatorInterface      $mediator
     */
    public function __construct(ContractorValidatorInterface $validator, ContractorRepositoryInterface $repository, ContractorFactoryInterface $factory, CommandMediatorInterface $mediator)
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
     * @throws ContractorNotFoundException
     * @throws ContractorCannotBeSavedException
     */
    public function put(ContractorApiDtoInterface $dto): ContractorInterface
    {
        try {
            $contractor = $this->repository->find($dto->getId());
        } catch (ContractorNotFoundException $e) {
            throw $e;
        }

        $contractor
            ->setInn($dto->getInn())
            ->setActive($dto->getActive())
            ->setFullName($dto->getFullName())
            ->setShortName($dto->getShortName())
            ->setUpdatedAt(new \DateTime());

        $this->mediator->onUpdate($dto, $contractor);

        $errors = $this->validator->validate($contractor);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new ContractorInvalidException($errorsString);
        }

        $this->repository->save($contractor);

        return $contractor;
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
            $contractor = $this->repository->find($dto->getId());
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
     * @return ContractorInterface
     * @throws ContractorCannotBeSavedException
     * @throws ContractorInvalidException
     */
    public function post(ContractorApiDtoInterface $dto): ContractorInterface
    {
        $contractor = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $contractor);

        $errors = $this->validator->validate($contractor);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new ContractorInvalidException($errorsString);
        }

        $this->repository->save($contractor);

        return $contractor;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}