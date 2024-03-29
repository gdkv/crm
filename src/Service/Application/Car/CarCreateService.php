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

        $car->setBrand(isset($carData['brand']) ? $carData['brand'] : null);
        $car->setModel(isset($carData['model']) ? $carData['model'] : null);
        $car->setEquipment(isset($carData['equipment']) ? $carData['equipment'] : null);
        $car->setTransmission(isset($carData['transmission']) ? $carData['transmission'] : null);
        $car->setEngine(isset($carData['engine']) ? $carData['engine'] : null);
        $car->setDrive(isset($carData['drive']) ? $carData['drive'] : null);
        $car->setYear(isset($carData['year']) ? $carData['year'] : null);
        $car->setColor(isset($carData['color']) ? $carData['color'] : null);
        $car->setPrice(isset($carData['price']) ? $carData['price'] : null);
        $car->setTradeInPrice(isset($carData['tradeInPrice']) ? $carData['tradeInPrice'] : null);
        $car->setTradeInOwnerPrice(isset($carData['tradeInOwnerPrice']) ? $carData['tradeInOwnerPrice'] : null);
        $car->setIsUsed(isset($carData['isUsed']) ? $carData['isUsed'] : null);
        $car->setAdditionalData(isset($carData['additionalData']) ? $carData['additionalData'] : null);

        $this->em->persist($car);
        $this->em->flush();


        return $car;
    }
}