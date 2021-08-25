<?php

namespace App\Controller;

use App\Controller\JsonResponseTrait;
use App\Controller\RoleTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;

class MainController extends AbstractController
{
    use JsonResponseTrait;
    use RoleTrait;

    public function __construct(
        private SerializerInterface $serializer,
    ){}

    #[Route('/', name: 'main')]
    public function index(): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted("ROLE_SUPERVISOR");
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "access_denied", code: "Недостаточно прав просмотра титула");
        }
        return $this->jsonResponse();
    }
}
