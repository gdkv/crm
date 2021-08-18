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

#[Route('/auth', name: 'auth.')]
class AuthController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request, LoginService $loginService): JsonResponse
    {
        return new JsonResponse(
            ($loginService)($request)
        );
    }

    #[Route('/me', name: 'me', methods: ['POST'])]
    public function me(UserService $userService): JsonResponse
    {
        return new JsonResponse(
            ($userService)()
        );
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    #[IsGranted("ROLE_SUPERVISOR", statusCode: 404, message: "Access Denied")]
    public function register(Request $request, RegisterService $registerService)
    {
        return new JsonResponse(
            ($registerService)($request)
        );
    }
}
