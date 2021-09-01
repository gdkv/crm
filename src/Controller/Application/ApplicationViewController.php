<?php

namespace App\Controller\Application;

use App\Controller\JsonResponseTrait;
use App\Entity\Application\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class ApplicationViewController extends AbstractController
{  
    use JsonResponseTrait;
    
    public function __construct(
        private SerializerInterface $serializer,
    ){}

    #[Route('/api/application/{id}', name: 'application.edit', methods: ['GET', 'HEAD'])]
    public function __invoke(?Application $application): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted('APPLICATION_VIEW');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для просмотра", code: 'access_denied', httpCode: 401);
        }

        if(!$application) {
            return $this->jsonResponseError(
                message: 'Application not found', 
                code: 'application_not_found', 
                httpCode: 404
            );
        }

        return $this->jsonResponse($application);
    } 

}
