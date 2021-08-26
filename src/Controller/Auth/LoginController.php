<?php

namespace App\Controller\Auth;

use App\Controller\JsonResponseTrait;
use App\Controller\RoleTrait;
use App\Entity\User;
use App\Service\Auth\LoginService;
use App\Service\User\UserGetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class LoginController extends AbstractController
{
    use JsonResponseTrait; 
    use RoleTrait;

    public function __construct(
        private SerializerInterface $serializer,
        private UserGetService $userGetService,
        private ?User $user = null,
    ){}

    #[Route('/auth/login', name: 'auth.login', methods: ['POST'])]
    public function __invoke(Request $request, LoginService $loginService): JsonResponse
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


}
