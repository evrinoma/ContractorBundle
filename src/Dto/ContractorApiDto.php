<?php

namespace Evrinoma\ContractorBundle\Dto;

use Evrinoma\ContractorBundle\Model\ContractorModelInterface;
use Evrinoma\ContrAgentBundle\Model\PaginationModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

class ContractorApiDto extends AbstractDto implements ContractorApiDtoInterface
{
//region SECTION: Fields
    private string $perPage = '1';

    private string $page = '0';

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

    /**
     * @param string $page
     *
     * @return ContractorApiDto
     */
    private function setPage(string $page): ContractorApiDto
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param string $perPage
     *
     * @return ContractorApiDto
     */
    private function setPerPage(string $perPage): ContractorApiDto
    {
        $this->perPage = $perPage;

        return $this;
    }
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $entityId = $request->get(ContractorModelInterface::ENTITY_ID);

            $perPage = $request->get(PaginationModelInterface::PER_PAGE);

            $page = $request->get(PaginationModelInterface::PAGE);

            if ($perPage) {
                $this->setPerPage($perPage);
            }

            if ($page) {
                $this->setPage($page);
            }

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

    /**
     * @return string
     */
    public function getPage(): string
    {
        return $this->page;
    }

    /**
     * @return string
     */
    public function getPerPage(): string
    {
        return $this->perPage;
    }
//endregion Getters/Setters
}