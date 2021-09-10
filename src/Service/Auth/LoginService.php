<?php
namespace App\Service\Auth;

use App\Controller\JsonResponseTrait;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\JWT\CreateTokenService;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

class LoginService {
    use JsonResponseTrait;

    public function __construct(
        private CreateTokenService $createTokenService,
        private UserRepository $userRepository,
        private SerializerInterface $serializer,
    ) {}

    public function __invoke(User $user): array
    {

        $jwtData = ($this->createTokenService)($user);

        return [
            "user" => $user,
            "token" => $jwtData['jwt'],
            "expiresAt" => $jwtData['expiresAt']->format("Y-m-d H:i:s"),
        ];

    }
}