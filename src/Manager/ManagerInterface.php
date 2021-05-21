<?php

namespace Evrinoma\ContractorBundle\Manager;

use Evrinoma\UtilsBundle\Rest\RestInterface;

interface ManagerInterface extends RestInterface
{
//region SECTION: Public
    public function saveFromApi(): void;

    public function deleteFromApi(): void;

    public function create():void;
//endregion Getters/Setters
}