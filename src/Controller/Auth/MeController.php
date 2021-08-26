<?php

namespace App\Controller\Auth;

use App\Controller\JsonResponseTrait;
use App\Controller\RoleTrait;
use App\Entity\User;
use App\Service\Auth\LoginService;
use App\Service\User\UserGetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MeController extends AbstractController
{
    use JsonResponseTrait; 
    use RoleTrait;

    public function __construct(
        private SerializerInterface $serializer,
        private UserGetService $userGetService,
        private ?User $user = null,
    ){}


    #[Route('/auth/me', name: 'auth.me', methods: ['POST'])]
    public function __invoke(LoginService $loginService): JsonResponse
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

}
