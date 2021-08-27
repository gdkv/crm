<?php

namespace App\Controller\Application;

use App\Controller\JsonResponseTrait;
use App\Repository\ApplicationRepository;
use App\Service\Application\ApplicationFilterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;


class ApplicationListController extends AbstractController
{  
    use JsonResponseTrait;
    
    public function __construct(
        private SerializerInterface $serializer,
    ){}

    #[Route('/api/application', name: 'application.list', methods: ['GET', 'HEAD'])]
    public function __invoke(
        Request $request, 
        ApplicationRepository $applicationRepository, 
        ApplicationFilterService $applicationFilterService
    ): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted('APPLICATION_VIEW');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для просмотра", code: 'access_denied');
        }

        $filters = ($applicationFilterService)($request);
        $limit = (int)$request->query->get('limit', 0);

        return $this->jsonResponse($applicationRepository->findFiltered($filters, [], $limit));
    }

}
