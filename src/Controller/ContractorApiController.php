<?php

namespace Evrinoma\ContractorBundle\Controller;

use Evrinoma\ContractorBundle\Manager\ManagerInterface;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

final class ContractorApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var FactoryDtoInterface
     */
    private FactoryDtoInterface $factoryDto;

    /**
     * @var ?Request
     */
    private ?Request $request;
    /**
     * @var ManagerInterface
     */
    private ManagerInterface $manager;
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
        FactoryDtoInterface $factoryDto,
        ManagerInterface $manager
    ) {
        parent::__construct($serializer);
        $this->request    = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->manager = $manager;
    }

//endregion Constructor

//region SECTION: Public
    /**
     * @Rest\Put("/api/contractor/save", options={"expose"=true}, name="api_save_contractor")
     * @OA\Put(tags={"contractor"})
     * @OA\Response(response=200,description="Returns contractors")
     *
     * @return JsonResponse
     */
    public function saveAction(): JsonResponse
    {
        $json = [];

        return $this->json(['message' => 'save', 'data' => $json], Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/contractor/delete", options={"expose"=true}, name="api_delete_contractor")
     * @OA\Delete(tags={"contractor"})
     * @OA\Response(response=200,description="Delete contractors")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        $json = [];

        return $this->json(['message' => 'delete', 'data' => $json], Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/contractor/search", options={"expose"=true}, name="api_search_contractor")
     * @OA\Get(tags={"contractor"})
     * @OA\Response(response=200,description="Search contractors")
     *
     * @return JsonResponse
     */
    public function searchAction(): JsonResponse
    {
        $json = [];

        return $this->json(['message' => 'search', 'data' => $json], Response::HTTP_OK);
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/api/contractor", options={"expose"=true}, name="api_contractor")
     * @OA\Get(tags={"contractor"})
     * @OA\Response(response=200,description="Return contractors")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        $json = [];

        return $this->json(['message' => 'get', 'data' => $json], Response::HTTP_OK);
    }
//endregion Getters/Setters
}