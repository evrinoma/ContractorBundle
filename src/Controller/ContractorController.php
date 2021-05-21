<?php

use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

final class ContractorController extends AbstractApiController
{
//region SECTION: Fields
    private $factoryDto;
    private $request;
//endregion Fields

//region SECTION: Constructor
    /**
     * ApiController constructor.
     *
     * @param SerializerInterface $serializer
     * @param RequestStack        $requestStack
     * @param FactoryDtoInterface $factoryDto
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto

    ) {
        parent::__construct($serializer);
        $this->request    = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
    }

//endregion Constructor

//region SECTION: Public
    public function saveAction()
    {
        $json = [];
        $this->json(['message' => 'save', 'data' => $json], Response::HTTP_OK);
    }

    public function deleteAction()
    {
        $json = [];
        $this->json(['message' => 'delete', 'data' => $json], Response::HTTP_OK);
    }

    public function searchAction()
    {
        $json = [];
        $this->json(['message' => 'search', 'data' => $json], Response::HTTP_OK);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAction()
    {
        $json = [];
        $this->json(['message' => 'get', 'data' => $json], Response::HTTP_OK);
    }
//endregion Getters/Setters
}