<?php
namespace App\Service\Auth;

use App\Repository\UserRepository;
use App\Service\JWT\CreateTokenService;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class LoginService {
    public function __construct(
        private CreateTokenService $createTokenService,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $encoder, 
    ) {}

    public function __invoke(Request $request): array
    {
        $request->request = new InputBag($request->toArray());

        $user = $this->userRepository->findOneBy(['username' => $request->request->get('username'),]);
        if (!$user || !$this->encoder->isPasswordValid($user, $request->request->get('password'))) {
            return ['status' => 'error', 'data' => ['message' => 'User not found or password is incorrect'], ];
        }
        
        $jwtData = ($this->createTokenService)($user);

        return [
            'status' => 'ok', 
            'data' => [
                "user" => $user->jsonSerialize(),
                "token" => $jwtData['jwt'],
                "expiresAt" => $jwtData['expiresAt']->format("Y-m-d H:i:s"),
            ],
        ];

    }
}