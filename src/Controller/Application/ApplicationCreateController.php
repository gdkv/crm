<?php

namespace App\Controller\Application;

use App\Controller\JsonResponseTrait;
use App\Entity\Application\Application;
use App\Service\Application\ApplicationCreateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;


class ApplicationCreateController extends AbstractController
{  
    use JsonResponseTrait;
    
    public function __construct(
        private SerializerInterface $serializer,
    ){}

    #[Route('/api/application', name: 'application.add', methods: ['POST'])]
    public function __invoke(
        Request $request, 
        ?Application $application, 
        ApplicationCreateService $applicationCreateService
    ): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted('APPLICATION_ADD');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для добавления", code: 'access_denied');
        }

        // Try to edit if granted
        try {
            $application = ($applicationCreateService)($request);
        } catch (Throwable $e) {
            return $this->jsonResponseError(message: $e->getMessage(), code: 'pdo_error');
        }


        return $this->jsonResponse($application);
    } 

}
