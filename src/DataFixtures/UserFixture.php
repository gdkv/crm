<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\DataFixtures\DealerFixture;
use App\Model\Enum\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
    ){}

    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'username' => 'dima', 
                'dealer' => '1', 
                'name' => 'Дмитрий Гудков', 
                'aliasName' => 'Федя Федоров', 
                'roles' => ['ROLE_SUPERVISOR'], 
                'plainPassword' => '123456',  
                '100' => 100, 
                'smsText' => 'ТЕКСТ', 
                'isWorking' => false, 
                'isRemote' => true, 
                'status' => 'WORK',
                'priority' => 1, 
                'disabled' => false, 
            ],
        ];

        $i = 0;
        foreach ($users as $userItem) {
            $i++;
            $user = new User();
            $user->setUsername($userItem['username']);
            $user->setDealer($this->getReference("dealer-{$userItem['dealer']}"));
            $user->setName($userItem['name']);
            $user->setAliasName($userItem['aliasName']);
            $user->setRoles($userItem['roles']);
            $user->setPassword($this->passwordEncoder->hashPassword($user, $userItem['plainPassword']));
            $user->setMangoId($userItem['100']);
            $user->setSmsText($userItem['smsText']);
            $user->setIsWorking($userItem['isWorking']);
            $user->setIsRemote($userItem['isRemote']);
            $user->setStatus(Status::get($userItem['status']));
            $user->setPriority($userItem['priority']);
            $user->setDisabled($userItem['disabled']);
            $this->setReference("user-{$i}", $user);
            
            $manager->persist($user);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DealerFixture::class,
        ];
    }
}
