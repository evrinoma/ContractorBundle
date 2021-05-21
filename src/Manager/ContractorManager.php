<?php
namespace Evrinoma\ContractorBundle\Manager;


use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;

class ContractorManager extends AbstractEntityManager implements ManagerInterface
{
    use RestTrait;

    public function saveFromApi(): void
    {
        // TODO: Implement saveFromApi() method.
    }

    public function deleteFromApi(): void
    {
        // TODO: Implement deleteFromApi() method.
    }

    public function create(): void
    {
        // TODO: Implement create() method.
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
}