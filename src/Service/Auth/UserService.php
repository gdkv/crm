<?php
namespace App\Service\Auth;

use App\Repository\UserRepository;
use App\Service\JWT\CreateTokenService;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class UserService {
    public function __construct(
        private Security $security,
        private CreateTokenService $createTokenService,
        private UserRepository $userRepository,
    ) {}

    public function __invoke(): array
    {
        // $request->request = new InputBag($request->toArray());

        $user = $this->security->getUser();
        if (!$user ) {
            return ['status' => 'error', 'data' => ['message' => 'User not found or password is incorrect'], ];
        }
        
        $user = $this->userRepository->findOneBy(['username' => $user->getUserIdentifier(),]);

        $jwtData = ($this->createTokenService)($user);

        return [
            'status' => 'ok', 
            'data' => [
                "user" => $user->jsonSerialize(),
                "token" => "Bearer {$jwtData['jwt']}",
                "expiresAt" => $jwtData['expiresAt']->format("Y-m-d H:i:s"),
            ],
        ];

    }
}