<?php
namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\JWT\CreateTokenService;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class UserGetService {
    public function __construct(
        private Security $security,
        private CreateTokenService $createTokenService,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $encoder, 
        private ?User $user = null,
    ) {}

    public function __invoke(?Request $request=null): ?User
    {
        if($request) {
            $request->request = new InputBag($request->toArray());
            $userName = $request->request->get('username');
            $userPassword = $request->request->get('password');
            $this->user = $this->userRepository->findOneBy(['username' => $userName,]);

            if($userPassword && !$this->encoder->isPasswordValid($this->user, $userPassword)){
                $this->user = null;
            }

        } else {
            $user = $this->security->getUser();
            if ($user) {
                $userName = $user->getUserIdentifier();
                $this->user = $this->userRepository->findOneBy(['username' => $userName,]);
            } else {
                $this->user = null;
            }

        }

        return $this->user;

    }
}