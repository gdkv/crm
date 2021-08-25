<?php

namespace App\Controller;

use App\Service\Auth\LoginService;
use App\Service\Auth\RegisterService;
use App\Service\Auth\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/auth', name: 'auth.')]
class AuthController extends AbstractController
{
    use JsonResponseTrait; 
    use RoleTrait;

    public function __construct(
        private SerializerInterface $serializer,
    ){}

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request, LoginService $loginService): JsonResponse
    {
        return $this->jsonResponse(($loginService)($request));
    }

    #[Route('/me', name: 'me', methods: ['POST'])]
    public function me(UserService $userService): JsonResponse
    {
        return $this->jsonResponse(($userService)());
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(Request $request, RegisterService $registerService)
    {
        try {
            $this->denyAccessUnlessGranted("ROLE_SUPERVISOR");
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "access_denied", code: "Недостаточно прав для заведения нового пользователя");
        }
        return $this->jsonResponse(($registerService)($request));
    }
}
