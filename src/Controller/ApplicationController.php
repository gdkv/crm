<?php

namespace App\Controller;

use App\Controller\JsonResponseTrait;
use App\Entity\Application\Application;
use App\Repository\ApplicationRepository;
use App\Service\Application\ApplicationCreateService;
use App\Service\Application\ApplicationUpdateService;
use App\Service\Application\ApplicationFilterService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/application', name: 'application.')]
class ApplicationController extends AbstractController
{  
    use JsonResponseTrait;
    
    public function __construct(
        private SerializerInterface $serializer,
    ){}

    #[Route('/{id}', name: 'edit', methods: ['POST'])]
    public function edit(
        Request $request, 
        Application $application, 
        ApplicationUpdateService $applicationUpdateService
    ): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted('APPLICATION_EDIT');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для редактирования", code: 'access_denied');
        }

        return $this->jsonResponse(($applicationUpdateService)($request, $application));
    } 

    #[Route('/{id}', name: 'view', methods: ['GET', 'HEAD'])]
    public function view(Application $application): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted('APPLICATION_VIEW');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для просмотра", code: 'access_denied');
        }

        return $this->jsonResponse($application);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function add(
        Request $request, 
        ApplicationCreateService $applicationCreateService
    ): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted('APPLICATION_ADD');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для добавления", code: 'access_denied');
        }

        return $this->jsonResponse(($applicationCreateService)($request));
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function index(
        Request $request, 
        ApplicationRepository $applicationRepository, 
        ApplicationFilterService $applicationFilterService
    ): Response
    {
        try {
            $this->denyAccessUnlessGranted('APPLICATION_VIEW');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для просмотра", code: 'access_denied');
        }

        $filters = ($applicationFilterService)($request);
        $limit = (int)$request->query->get('limit', 0);

        return $this->jsonResponse($applicationRepository->findFilteredArray($filters, [], $limit));
    }
}
