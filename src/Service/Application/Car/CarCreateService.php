<?php
namespace App\Service\Application\Car;

use App\Entity\Application\Car;
use App\Entity\Application\Client;
use App\Entity\User;
use App\Model\Enum\Gender;
use App\Model\Enum\Status;
use App\Repository\DealerRepository;
use App\Repository\UserRepository;
use App\Service\JWT\CreateTokenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CarCreateService {
    public function __construct(
        private CreateTokenService $createTokenService,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $encoder, 
        private DealerRepository $dealerRepository,
        private EntityManagerInterface $em,
    ) {}

    public function __invoke(array $carData): Car
    {
        $car = new Car();

        $car->setBrand($carData['brand']);
        $car->setModel($carData['model']);
        $car->setEquipment($carData['equipment']);
        $car->setTransmission($carData['transmission']);
        $car->setEngine($carData['engine']);
        $car->setDrive($carData['drive']);
        $car->setYear($carData['year']);
        $car->setColor($carData['color']);
        $car->setPrice($carData['price']);
        $car->setTradeInPrice($carData['tradeInPrice']);
        $car->setTradeInOwnerPrice($carData['tradeInOwnerPrice']);
        $car->setIsUsed($carData['isUsed']);
        $car->setAdditionalData($carData['additionalData']);

        $this->em->persist($car);
        $this->em->flush();


        return $car;
    }
}