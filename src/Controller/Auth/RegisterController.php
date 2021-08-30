<?php

namespace App\Controller\Auth;

use App\Controller\JsonResponseTrait;
use App\Controller\RoleTrait;
use App\Entity\User;
use App\Service\Auth\RegisterService;
use App\Service\User\UserGetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class RegisterController extends AbstractController
{
    use JsonResponseTrait; 
    use RoleTrait;

    public function __construct(
        private SerializerInterface $serializer,
        private UserGetService $userGetService,
        private ?User $user = null,
    ){}

    #[Route('/auth/register', name: 'auth.register', methods: ['POST'])]
    public function __invoke(Request $request, RegisterService $registerService)
    {
        // Check access
        try {
            $this->denyAccessUnlessGranted("ROLE_SUPERVISOR");
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(
                message: "access_denied", 
                code: "Недостаточно прав для заведения нового пользователя",
                httpCode: 403
            );
        }

        // Try to add if granted
        try {
            $this->user = ($registerService)($request);
        } catch (Throwable $e) {
            return $this->jsonResponseError(message: $e->getMessage(), code: 'pdo_error');
        }

        // Return result
        return $this->jsonResponse($this->user);
    }
}
