<?php
namespace App\Service\Auth;

use App\Entity\User;
use App\Model\Enum\Role;
use App\Model\Enum\Status;
use App\Repository\DealerRepository;
use App\Repository\UserRepository;
use App\Service\JWT\CreateTokenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService {
    public function __construct(
        private CreateTokenService $createTokenService,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $encoder, 
        private DealerRepository $dealerRepository,
        private EntityManagerInterface $em,
    ) {}

    public function __invoke(Request $request): User
    {
        $request->request = new InputBag($request->toArray());

        $user = new User();

        $dealerData = $request->request->all('dealer');
        $dealer = $this->dealerRepository->find($dealerData['id']);

        $user->setUsername($request->request->get('username'));
        $user->setDealer($dealer);
        $user->setName($request->request->get('name'));
        $user->setAliasName($request->request->get('aliasName'));
        $user->setRoles(
            Role::get($request->request->get('role'))
        );
        $user->setPassword(
            $this->encoder->hashPassword(
                $user, 
                $request->request->get('plainPassword')
            )
        );
        $user->setMangoId($request->request->get('mangoId'));
        $user->setSmsText($request->request->get('smsText'));
        $user->setIsWorking($request->request->get('isWorking'));
        $user->setIsRemote($request->request->get('isRemote'));
        $user->setStatus(
            Status::get($request->request->get('status'))
        );
        $user->setPriority(100);
        $user->setDisabled($request->request->get('disabled'));

        $this->em->persist($user);
        $this->em->flush();

        // return $user;
        return $user;
    }
}