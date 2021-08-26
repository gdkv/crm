<?php
namespace App\Service\Application\Car;

use App\Entity\Application\Car;
use Doctrine\ORM\EntityManagerInterface;

class CarUpdateService {
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    public function __invoke(array $carData, ?Car $car = null): Car
    {
        if (!$car) {
            $car = new Car();
            $this->em->persist($car);
        }
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

        $this->em->flush();

        return $car;
    }
}