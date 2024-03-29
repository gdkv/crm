<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\DataFixtures\DealerFixture;
use App\Model\Enum\Role;
use App\Model\Enum\Status;
use DateTime;
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
                'role' => 'ROLE_ADMIN', 
                'plainPassword' => '123456',  
                'mangoId' => 100, 
                'smsText' => 'Ждем Вас в Автоцентр Северо-Запад.Скидка на автомобили до 40% м.Тушинская Волоколамское шоссе, д 120', 
                'isWorking' => false, 
                'isRemote' => true, 
                'status' => 'WORK',
                'priority' => 1, 
                'disabled' => false, 
            ],
            [
                'username' => 'oleg', 
                'dealer' => '2', 
                'name' => 'Просто Олег', 
                'aliasName' => 'Иван Виктор', 
                'role' => 'ROLE_OPERATOR', 
                'plainPassword' => '123456',  
                'mangoId' => 100, 
                'smsText' => 'Ждем Вас в Автоцентр Северо-Запад.Скидка на автомобили до 40% м.Тушинская Волоколамское шоссе, д 120', 
                'isWorking' => false, 
                'isRemote' => true, 
                'status' => 'WORK',
                'priority' => 1, 
                'disabled' => false, 
            ],
            [
                'username' => 'kirill', 
                'dealer' => '1', 
                'name' => 'Иван Олег', 
                'aliasName' => 'Федор Виктор', 
                'role' => 'ROLE_OPERATOR', 
                'plainPassword' => '123456',  
                'mangoId' => 100, 
                'smsText' => 'Ждем Вас в Автоцентр Северо-Запад.Скидка на автомобили до 40% м.Тушинская Волоколамское шоссе, д 120', 
                'isWorking' => false, 
                'isRemote' => true, 
                'status' => 'WORK',
                'priority' => 1, 
                'disabled' => false, 
            ],
            [
                'username' => 'guest', 
                'dealer' => '2', 
                'name' => 'Гость', 
                'aliasName' => '', 
                'role' => 'ROLE_GUEST', 
                'plainPassword' => '123456',  
                'mangoId' => null, 
                'smsText' => null, 
                'isWorking' => false, 
                'isRemote' => true, 
                'status' => 'WORK',
                'priority' => 1, 
                'expiresAt' => new DateTime('2021-08-22 00:00:00'),
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
            $user->setRoles(Role::get($userItem['role']));
            $user->setPassword($this->passwordEncoder->hashPassword($user, $userItem['plainPassword']));
            $user->setMangoId($userItem['mangoId']);
            $user->setSmsText($userItem['smsText']);
            $user->setIsWorking($userItem['isWorking']);
            $user->setIsRemote($userItem['isRemote']);
            $user->setStatus(Status::get($userItem['status']));
            $user->setPriority($userItem['priority']);
            $user->setDisabled($userItem['disabled']);

            if (isset($userItem['expiresAt'])) {
                $user->setExpiresAt($userItem['expiresAt']);
            }
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
