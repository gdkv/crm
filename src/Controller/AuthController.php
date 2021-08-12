<?php

namespace App\Controller;

use App\Repository\UserRepository;
use DateTime;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/auth', name: 'auth.')]
class AuthController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(
        Request $request, 
        UserRepository $userRepository, 
        UserPasswordHasherInterface $encoder
    ): JsonResponse
    {
        $request->request = new InputBag($request->toArray());

        $user = $userRepository->findOneBy(['username' => $request->request->get('username'),]);
        if (!$user || !$encoder->isPasswordValid($user, $request->request->get('password'))) {
            return new JsonResponse(['message' => 'fail!']);
        }
 
        $jwt = JWT::encode(
            [
                "username" => $user->getUserIdentifier(),
                "expiresAt" => (new DateTime())->modify("+5 minutes")->getTimestamp(),
            ], 
            $this->getParameter('jwt_secret')
        );

        return new JsonResponse(['message' => 'success!', 'token' => "Bearer {$jwt}"]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(Request $request)
    {

    }
}
