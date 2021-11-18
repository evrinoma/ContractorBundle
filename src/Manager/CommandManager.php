<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeRemovedException;
use Evrinoma\ContractorBundle\Exception\ContractorCannotBeSavedException;
use Evrinoma\ContractorBundle\Exception\ContractorInvalidException;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Factory\ContractorFactoryInterface;
use Evrinoma\ContractorBundle\Mediator\CommandMediatorInterface;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;
use Evrinoma\ContractorBundle\Repository\ContractorCommandRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private ValidatorInterface                   $validator;
    private ContractorCommandRepositoryInterface $repository;
    private ContractorFactoryInterface           $factory;
    private CommandMediatorInterface             $mediator;
//endregion Fields

//region SECTION: Constructor
    /**
     * CommandManager constructor.
     *
     * @param ValidatorInterface                   $validator
     * @param ContractorCommandRepositoryInterface $repository
     * @param ContractorFactoryInterface           $factory
     * @param CommandMediatorInterface             $mediator
     */
    public function __construct(ValidatorInterface $validator, ContractorCommandRepositoryInterface $repository, ContractorFactoryInterface $factory, CommandMediatorInterface $mediator)
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
     * @return ContractorInterface
     * @throws ContractorCannotBeSavedException
     * @throws ContractorInvalidException
     * @throws ContractorNotFoundException
     */
    public function put(ContractorApiDtoInterface $dto): ContractorInterface
    {
        try {
            $contractor = $this->repository->find($dto->getId());
        } catch (ContractorNotFoundException $e) {
            throw $e;
        }

        $contractor
            ->setIdentity(trim($dto->getIdentity()))
            ->setDependency(trim($dto->getDependency()))
            ->setName(trim($dto->getName()))
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActive($dto->getActive());

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