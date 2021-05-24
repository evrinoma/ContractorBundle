<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

interface ManagerInterface extends RestInterface
{
//region SECTION: Public
    public function putFromApi(DtoInterface $dto): void;

    public function deleteFromApi(DtoInterface $dto): void;

    public function postFromApi(DtoInterface $dto):void;

    public function getFromApi(DtoInterface $dto):void;
//endregion Getters/Setters
}