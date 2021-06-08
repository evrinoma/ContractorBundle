<?php

namespace Evrinoma\ContractorBundle\Controller;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Manager\CommandManagerInterface;
use Evrinoma\ContractorBundle\Manager\QueryManagerInterface;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class ContractorApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var ?Request
     */
    private ?Request $request;
    /**
     * @var FactoryDtoInterface
     */
    private FactoryDtoInterface $factoryDto;
    /**
     * @var CommandManagerInterface|RestInterface
     */
    private CommandManagerInterface $commandManager;
    /**
     * @var QueryManagerInterface|RestInterface
     */
    private QueryManagerInterface $queryManager;
    /**
     * @var string
     */
    private string $dtoClass;
//endregion Fields

//region SECTION: Constructor


    /**
     * ApiController constructor.
     *
     * @param SerializerInterface     $serializer
     * @param RequestStack            $requestStack
     * @param FactoryDtoInterface     $factoryDto
     * @param CommandManagerInterface $commandManager
     * @param QueryManagerInterface   $queryManager
     * @param string                  $dtoClass
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        CommandManagerInterface $commandManager,
        QueryManagerInterface $queryManager,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request        = $requestStack->getCurrentRequest();
        $this->factoryDto     = $factoryDto;
        $this->commandManager = $commandManager;
        $this->queryManager   = $queryManager;
        $this->dtoClass       = $dtoClass;
    }

//endregion Constructor

//region SECTION: Public
    /**
     * @Rest\Post("/api/contractor/create", options={"expose"=true}, name="api_create_contractor")
     * @OA\Post(
     *     tags={"contractor"},
     *     description="the method perform create contractor",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\ContractorBundle\Dto\ContractorApiDto",
     *                  "identity":"7702070139",
     *                  "dependency": "770943002",
     *                  "name":"Банк ВТБ (публичное акционерное общество)"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\ContractorBundle\Dto\ContractorApiDto"),
     *               @OA\Property(property="identity",type="string"),
     *               @OA\Property(property="dependency",type="string"),
     *               @OA\Property(property="name",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Create contractor")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var ContractorApiDtoInterface $contractorApiDto */
        $contractorApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;

        try {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($contractorApiDto, $commandManager, &$json) {
                    $json = $commandManager->post($contractorApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = ['errors' => $e->getMessage()];
            $this->commandManager->setRestClientErrorBadRequest();
        }

        return $this->setSerializeGroup('api_post_contractor')->json(['message' => 'Create contractor', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/contractor/save", options={"expose"=true}, name="api_save_contractor")
     * @OA\Put(
     *     tags={"contractor"},
     *     description="the method perform save contractor for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\ContractorBundle\Dto\ContractorApiDto",
     *                  "id":"3",
     *                  "identity":"7702070139",
     *                  "active": "b",
     *                  "dependency": "770943002",
     *                  "name":"Банк ВТБ (публичное акционерное общество)"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\ContractorBundle\Dto\ContractorApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="identity",type="string"),
     *               @OA\Property(property="active",type="string"),
     *               @OA\Property(property="dependency",type="string"),
     *               @OA\Property(property="name",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Save contractor")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var ContractorApiDtoInterface $contractorApiDto */
        $contractorApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;

        if ($contractorApiDto->hasId()) {
            try {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($contractorApiDto, $commandManager, &$json) {
                        $json = $commandManager->put($contractorApiDto);
                    }
                );
            } catch (\Exception $e) {
                $this->commandManager->setRestClientErrorBadRequest();
                $json = ['errors' => $e->getMessage()];
            }
        } else {
            $this->commandManager->setRestClientErrorBadRequest();
            $json = ['errors' => 'ошибка'];
        }

        return $this->setSerializeGroup('api_put_contractor')->json(['message' => 'Save contractor', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/contractor/delete", options={"expose"=true}, name="api_delete_contractor")
     * @OA\Delete(
     *     tags={"contractor"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractorBundle\Dto\ContractorApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Delete contractors")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var ContractorApiDtoInterface $contractorApiDto */
        $contractorApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;

        if ($contractorApiDto->hasId()) {
            try {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($contractorApiDto, $commandManager, &$json) {
                        $commandManager->delete($contractorApiDto);
                        $json = ['OK'];
                    }
                );
            } catch (\Exception $e) {
                $this->commandManager->setRestClientErrorBadRequest();
                $json = ['errors' => $e->getMessage()];
            }
        } else {
            $this->commandManager->setRestClientErrorBadRequest();
            $json = ['errors' => 'id contractor not found'];
        }

        return $this->json(['message' => 'Delete contractor', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/contractor/criteria", options={"expose"=true}, name="api_contractor_criteria")
     * @OA\Get(
     *     tags={"contractor"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractorBundle\Dto\ContractorApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="identity",
     *         in="query",
     *         name="identity",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="dependency",
     *         in="query",
     *         name="dependency",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="name",
     *         in="query",
     *         name="name",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="active",
     *         in="query",
     *         name="active",
     *         @OA\Schema(
     *           type="string",
     *           default="a",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Return contractors")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var ContractorApiDtoInterface $contractorApiDto */
        $contractorApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->criteria($contractorApiDto);
        } catch (\Exception $e) {
            $this->queryManager->setRestClientErrorBadRequest();
            $json = ['errors' => $e->getMessage()];
        }

        return $this->setSerializeGroup('api_get_contractor')->json(['message' => 'Get contractors', 'data' => $json], $this->queryManager->getRestStatus());
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/api/contractor", options={"expose"=true}, name="api_contractor")
     * @OA\Get(
     *     tags={"contractor"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractorBundle\Dto\ContractorApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Return contractors")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var ContractorApiDtoInterface $contractorApiDto */
        $contractorApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($contractorApiDto);
        } catch (\Exception $e) {
            $this->queryManager->setRestClientErrorBadRequest();
            $json = ['errors' => $e->getMessage()];
        }

        return $this->setSerializeGroup('api_get_contractor')->json(['message' => 'Get contractors', 'data' => $json], $this->queryManager->getRestStatus());
    }
//endregion Getters/Setters


}