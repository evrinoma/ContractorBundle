<?php

namespace Evrinoma\ContractorBundle\Dto;

use Evrinoma\ContractorBundle\Model\ContractorModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Symfony\Component\HttpFoundation\Request;

class ContractorApiDto extends AbstractDto implements ContractorApiDtoInterface
{
//region SECTION: Fields
    private string $id = '';

    private string $inn = '';

    private string $fullName = '';

    private string $shortName = '';

    private string $active = ActiveModel::ACTIVE;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return $this->id !== '';
    }

    public function hasShortName(): bool
    {
        return $this->shortName !== '';
    }

    public function hasFullName(): bool
    {
        return $this->fullName !== '';
    }

    public function hasInn(): bool
    {
        return $this->inn !== '';
    }
//endregion Public

//region SECTION: Private
    /**
     * @param string $active
     *
     * @return ContractorApiDto
     */
    private function setActive(string $active): ContractorApiDto
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return ContractorApiDto
     */
    private function setId(string $id): ContractorApiDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $inn
     *
     * @return ContractorApiDto
     */
    private function setInn(string $inn): ContractorApiDto
    {
        $this->inn = $inn;

        return $this;
    }

    /**
     * @param string $fullName
     *
     * @return ContractorApiDto
     */
    private function setFullName(string $fullName): ContractorApiDto
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @param string $shortName
     *
     * @return ContractorApiDto
     */
    private function setShortName(string $shortName): ContractorApiDto
    {
        $this->shortName = $shortName;

        return $this;
    }
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id        = $request->get(ContractorModelInterface::ID);
            $inn       = $request->get(ContractorModelInterface::INN);
            $fullName  = $request->get(ContractorModelInterface::FULL_NAME);
            $shortName = $request->get(ContractorModelInterface::SHORT_NAME);
            $active = $request->get(ContractorModelInterface::ACTIVE);

            if ($active) {
                $this->setActive($active);
            }

            if ($fullName) {
                $this->setFullName($fullName);
            }

            if ($shortName) {
                $this->setShortName($shortName);
            }

            if ($inn) {
                $this->setInn($inn);
            }

            if ($id) {
                $this->setId($id);
            }
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getActive(): string
    {
        return $this->active;
    }

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
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
//endregion Getters/Setters
}