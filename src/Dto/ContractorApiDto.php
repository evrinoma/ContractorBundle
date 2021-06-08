<?php

namespace Evrinoma\ContractorBundle\Dto;

use Evrinoma\ContractorBundle\Model\ContractorModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

class ContractorApiDto extends AbstractDto implements ContractorApiDtoInterface
{
//region SECTION: Fields
    private string $id = '';

    private string $identity = '';

    private string $dependency = '';

    private string $name = '';

    private string $active = '';
//endregion Fields

//region SECTION: Protected
    /**
     * @param string $active
     *
     * @return ContractorApiDto
     */
    protected function setActive(string $active): ContractorApiDto
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return ContractorApiDto
     */
    protected function setId(string $id): ContractorApiDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $identity
     *
     * @return ContractorApiDto
     */
    protected function setIdentity(string $identity): ContractorApiDto
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * @param string $dependency
     *
     * @return ContractorApiDto
     */
    protected function setDependency(string $dependency): ContractorApiDto
    {
        $this->dependency = $dependency;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return ContractorApiDto
     */
    protected function setName(string $name): ContractorApiDto
    {
        $this->name = $name;

        return $this;
    }
//endregion Protected

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return $this->id !== '';
    }

    public function hasName(): bool
    {
        return $this->name !== '';
    }

    public function hasDependency(): bool
    {
        return $this->dependency !== '';
    }

    public function hasIdentity(): bool
    {
        return $this->identity !== '';
    }

    public function hasActive(): bool
    {
        return $this->active !== '';
    }
//endregion Public

//region SECTION: Private
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id         = $request->get(ContractorModelInterface::ID);
            $identity   = $request->get(ContractorModelInterface::IDENTITY);
            $dependency = $request->get(ContractorModelInterface::DEPENDENCY);
            $name       = $request->get(ContractorModelInterface::NAME);
            $active     = $request->get(ContractorModelInterface::ACTIVE);

            if ($active) {
                $this->setActive($active);
            }

            if ($dependency) {
                $this->setDependency($dependency);
            }

            if ($name) {
                $this->setName($name);
            }

            if ($identity) {
                $this->setIdentity($identity);
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
    public function getId(): string
    {
        return $this->id;
    }

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
    public function getIdentity(): string
    {
        return $this->identity;
    }

    /**
     * @return string
     */
    public function getDependency(): string
    {
        return $this->dependency;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}