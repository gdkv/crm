<?php
namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\JWT\CreateTokenService;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class UserCheckUsernameService {
    public function __construct(
        private Security $security,
        private CreateTokenService $createTokenService,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $encoder, 
        private ?User $user = null,
    ) {}

    public function __invoke(string $userName): array
    {
        $response = [
            "check" => $userName,
            "isExist" => false,
        ];
          
        $this->user = $this->userRepository->findOneBy(['username' => $userName,]);
        if($this->user instanceof User){
            $response["isExist"] = true;
        }

        return $response;
    }
}