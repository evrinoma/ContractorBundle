<?php

namespace Evrinoma\ContractorBundle\Dto;

use Evrinoma\ContractorBundle\Model\ContractorModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

class ContractorApiDto extends AbstractDto implements ContractorApiDtoInterface
{
//region SECTION: Fields
    private string $entityId = '';

    private string $inn = '';

    private string $fullName = '';

    private string $shortname = '';
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasEntityId(): bool
    {
        return $this->entityId !== '';
    }
//endregion Public

//region SECTION: Private
    /**
     * @param string $entityId
     *
     * @return ContractorApiDto
     */
    private function setEntityId(string $entityId): ContractorApiDto
    {
        $this->entityId = $entityId;

        return $this;
    }
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $entityId = $request->get(ContractorModelInterface::ENTITY_ID);

            if ($entityId) {
                $this->setEntityId($entityId);
            }
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @return string
     */
    public function getShortname(): string
    {
        return $this->shortname;
    }

    /**
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }
//endregion Getters/Setters
}