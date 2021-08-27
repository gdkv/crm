<?php

namespace App\Controller\Application;

use App\Controller\JsonResponseTrait;
use App\Entity\Application\Application;
use App\Service\Application\ApplicationUpdateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;


class ApplicationUpdateController extends AbstractController
{  
    use JsonResponseTrait;
    
    public function __construct(
        private SerializerInterface $serializer,
    ){}

    #[Route('/api/application/{id}', name: 'application.update', methods: ['POST'])]
    public function __invoke(
        Request $request, 
        ?Application $application, 
        ApplicationUpdateService $applicationUpdateService
    ): JsonResponse
    {
        // check user right access
        try {
            $this->denyAccessUnlessGranted('APPLICATION_EDIT');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для редактирования", code: 'access_denied');
        }

        // 404 if application not found
        if(!$application) {
            return $this->jsonResponseError(
                message: 'Application not found', 
                code: 'application_not_found', 
                httpCode: 404
            );
        }

        // try to edit if granted
        try {
            $application = ($applicationUpdateService)($request, $application);
        } catch (Throwable $e) {
            return $this->jsonResponseError(message: $e->getMessage(), code: 'pdo_error');
        }

        return $this->jsonResponse($application);
    } 

}
