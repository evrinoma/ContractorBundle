<?php

namespace Evrinoma\ContractorBundle\Controller;

use Evrinoma\ContractorBundle\Dto\ContractorApiDto;
use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Manager\ManagerInterface;
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
     * @var ManagerInterface
     */
    private ManagerInterface $manager;

    /**
     * @var string
     */
    private string $dtoClass;
//endregion Fields

//region SECTION: Constructor


    /**
     * ApiController constructor.
     *
     * @param SerializerInterface $serializer
     * @param RequestStack        $requestStack
     * @param FactoryDtoInterface $factoryDto
     * @param ManagerInterface    $manager
     * @param string              $dtoClass
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        ManagerInterface $manager,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request    = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->manager    = $manager;
        $this->dtoClass   = $dtoClass;
    }

//endregion Constructor

//region SECTION: Public
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
        $manager          = $this->manager;

        if ($contractorApiDto->hasContractor()) {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($contractorApiDto, $manager, &$json) {
                    $manager->putFromApi($contractorApiDto);
                    $json = ['OK'];
                }
            );
        } else {
            $this->manager->setRestClientErrorBadRequest();
            $json = ['errors' => 'ошибка'];
        }

        return $this->json(['message' => 'Save contractor', 'data' => $json], $this->manager->getRestStatus());
    }

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
        $manager          = $this->manager;

        if ($contractorApiDto->hasContractor()) {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($contractorApiDto, $manager, &$json) {
                    $manager->postFromApi($contractorApiDto);
                    $json = ['OK'];
                }
            );
        } else {
            $this->manager->setRestClientErrorBadRequest();
            $json = ['errors' => 'ошибка'];
        }

        return $this->json(['message' => 'Create contractor', 'data' => $json], $this->manager->getRestStatus());
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
        $manager          = $this->manager;

        if ($contractorApiDto->hasContractor()) {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($contractorApiDto, $manager, &$json) {
                    $manager->deleteFromApi($contractorApiDto);
                    $json = ['OK'];
                }
            );
        } else {
            $this->manager->setRestClientErrorBadRequest();
            $json = ['errors' => 'id contractor not found'];
        }

        return $this->json(['message' => 'Delete contractor', 'data' => $json], $this->manager->getRestStatus());
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
        /** @var ContractorApiDtoInterface $contractorApiDto */
        $contractorApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        if ($contractorApiDto->hasContractor()) {
            try {
                $json = [];
                $this->manager->getFromApi($contractorApiDto);
            } catch (\Exception $e) {
                $json = ['errors' => $e->getMessage()];
            }
        } else {
            $this->manager->setRestClientErrorBadRequest();

            $json = ['errors' => 'Не переданы необходимые данные для получения contractors'];
        }

        return $this->setSerializeGroup('api_get_comment')->json(['message' => 'Get contractors', 'data' => $json], $this->manager->getRestStatus());
    }
//endregion Getters/Setters
}