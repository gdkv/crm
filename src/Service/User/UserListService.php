<?php
namespace App\Service\User;

use App\Entity\User;
use App\Model\Enum\Role;
use App\Repository\UserRepository;
use App\Service\JWT\CreateTokenService;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class UserListService {
    public function __construct(
        private Security $security,
        private CreateTokenService $createTokenService,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $encoder, 
        private iterable $users = [],
    ) {}

    public function __invoke(): ?iterable
    {
        $this->users = $this->userRepository->findBy(['role' => Role::ROLE_OPERATOR(),]);

        return $this->users;

    }
}