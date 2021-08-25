<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Auth\LoginService;
use App\Service\Auth\RegisterService;
use App\Service\Auth\UserService;
use App\Service\User\UserGetService;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

#[Route('/auth', name: 'auth.')]
class AuthController extends AbstractController
{
    use JsonResponseTrait; 
    use RoleTrait;

    public function __construct(
        private SerializerInterface $serializer,
        private UserGetService $userGetService,
        private ?User $user = null,
    ){}

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request, LoginService $loginService): JsonResponse
    { 
        $this->user = ($this->userGetService)($request);
        if (!$this->user) {
            return $this->jsonResponseError(
                message: "User not found or password is incorrect", 
                code: 'user_not_found',
                httpCode: 401
            );
        }

        return $this->jsonResponse(($loginService)($this->user));
    }

    #[Route('/me', name: 'me', methods: ['POST'])]
    public function me(LoginService $loginService): JsonResponse
    {
        $this->user = ($this->userGetService)();
        if (!$this->user) {
            return $this->jsonResponseError(
                message: "User not found or password is incorrect", 
                code: 'user_not_found',
                httpCode: 401
            );
        }

        return $this->jsonResponse(($loginService)($this->user));
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(Request $request, RegisterService $registerService)
    {
        // Check access
        try {
            $this->denyAccessUnlessGranted("ROLE_SUPERVISOR");
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(
                message: "access_denied", 
                code: "Недостаточно прав для заведения нового пользователя",
                httpCode: 401
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
