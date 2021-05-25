<?php

namespace Evrinoma\ContractorBundle\Controller;

use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Manager\CommandManagerInterface;
use Evrinoma\ContractorBundle\Manager\QueryManagerInterface;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
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
     * @var CommandManagerInterface
     */
    private CommandManagerInterface $commandManager;
    /**
     * @var QueryManagerInterface
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
        $this->dtoClass       = $dtoClass;
    }

//endregion Constructor

//region SECTION: Public
    /**
     * @Rest\Post("/api/contractor/create", options={"expose"=true}, name="api_create_contractor")
     * @OA\Post(tags={"contractor"})
     * @OA\Response(response=200,description="Create contractors")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var ContractorApiDtoInterface $contractorApiDto */
        $contractorApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $manager          = $this->commandManager;

        try {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($contractorApiDto, $manager, &$json) {
                    $manager->post($contractorApiDto);
                    $json = ['OK'];
                }
            );
        } catch (\Exception $e) {
            $json = ['errors' => $e->getMessage()];
            $this->commandManager->setRestClientErrorBadRequest();
        }

        return $this->json(['message' => 'Create contractor', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/contractor/save", options={"expose"=true}, name="api_save_contractor")
     * @OA\Put(tags={"contractor"})
     * @OA\Response(response=200,description="Save contractors")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var ContractorApiDtoInterface $contractorApiDto */
        $contractorApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $manager          = $this->commandManager;

        if ($contractorApiDto->hasEntityId()) {
            try {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($contractorApiDto, $manager, &$json) {
                        $manager->put($contractorApiDto);
                        $json = ['OK'];
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

        return $this->json(['message' => 'Save contractor', 'data' => $json], $this->commandManager->getRestStatus());
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
        /** @var ContractorApiDtoInterface $contractorApiDto */
        $contractorApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $manager          = $this->commandManager;

        if ($contractorApiDto->hasEntityId()) {
            try {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($contractorApiDto, $manager, &$json) {
                        $manager->delete($contractorApiDto);
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
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/api/contractor", options={"expose"=true}, name="api_contractor")
     * @OA\Get(
     *     tags={"contractor"},
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="entityId",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="3",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="page number",
     *         in="query",
     *         name="page",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="0",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="records count",
     *         in="query",
     *         name="per_page",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="1",
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
            $json = [];
            $this->queryManager->get($contractorApiDto);
        } catch (\Exception $e) {
            $this->commandManager->setRestClientErrorBadRequest();
            $json = ['errors' => $e->getMessage()];
        }

        return $this->setSerializeGroup('api_get_comment')->json(['message' => 'Get contractors', 'data' => $json], $this->commandManager->getRestStatus());
    }
//endregion Getters/Setters
}