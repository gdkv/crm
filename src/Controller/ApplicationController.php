<?php

namespace App\Controller;

use App\Entity\Application\Application;
use App\Repository\ApplicationRepository;
use App\Service\Application\ApplicationCreateService;
use App\Service\Application\ApplicationFilterService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/application', name: 'application.')]
class ApplicationController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function index(
        Request $request, 
        ApplicationRepository $applicationRepository, 
        ApplicationFilterService $applicationFilterService
    ): JsonResponse
    {
        $filters = ($applicationFilterService)($request);

        $limit = (int)$request->query->get('limit', 0);

        return new JsonResponse([
            'status' => 'ok',
            'data' => $applicationRepository->findFilteredArray($filters, [], $limit),
        ]);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    #[IsGranted('APPLICATION_ADD', statusCode: 401, message: 'Access Denied!')]
    public function add(Request $request, ApplicationCreateService $applicationCreateService): JsonResponse
    {
        return new JsonResponse([
            ($applicationCreateService)($request)
        ]);
    }

    #[Route('/{id}', name: 'view')]
    #[IsGranted('APPLICATION_VIEW', statusCode: 401, message: 'Access Denied!')]
    public function view(Application $application): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok', 
            'data' => $application->jsonSerialize()
        ]);
    }
}
