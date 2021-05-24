<?php

namespace Evrinoma\ContractorBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\ContractorBundle\Exception\ContractorIsInValidException;
use Evrinoma\ContractorBundle\Exception\ContractorNotFoundException;
use Evrinoma\ContractorBundle\Provider\ProviderInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContractorManager extends AbstractEntityManager implements ManagerInterface
{
    use RestTrait;

//region SECTION: Fields
    private ValidatorInterface $validator;
    private ProviderInterface  $provider;
//endregion Fields

//region SECTION: Constructor
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, ProviderInterface $provider)
    {
        parent::__construct($entityManager);

        $this->provider  = $provider;
        $this->validator = $validator;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param DtoInterface $dto
     *
     * @throws ContractorIsInValidException
     */
    public function putFromApi(DtoInterface $dto): void
    {
        if ($this->validator->validate($dto)) {
            throw new ContractorIsInValidException("Can't update, contractor is invalid");
        }

        $this->provider->update($dto);
    }

    public function deleteFromApi(DtoInterface $dto): void
    {
        $this->provider->delete($dto);
    }

    public function postFromApi(DtoInterface $dto): void
    {
        if ($this->validator->validate($dto)) {
            throw new ContractorIsInValidException("Can't create, contractor is invalid");
        }

        $this->provider->create($dto);
    }

    public function getFromApi(DtoInterface $dto): void
    {
        $this->provider->read($dto);

        throw new ContractorNotFoundException("Can't found contractor");
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}