<?php


namespace Evrinoma\ContractorBundle\Provider;


use Evrinoma\DtoBundle\Dto\DtoInterface;

class BaseProvider implements ProviderInterface
{

    public function update(DtoInterface $dto)
    {
        return $dto;
    }

    public function delete(DtoInterface $dto)
    {
        return $dto;
    }

    public function create(DtoInterface $dto)
    {
        return $dto;
    }

    public function read(DtoInterface $dto)
    {
        return $dto;
    }
}