<?php

namespace App\DataFixtures;

use App\Entity\Application\Application;
use App\Model\Enum\ApplicationStatus;
use App\Model\Enum\Reason;
use App\Model\Enum\Source;
use App\Model\Enum\Type;
use App\Repository\UserRepository;
use App\Service\Application\ApplicationAddService;
use App\Service\Application\Car\CarCreateService;
use App\Service\Application\Client\ClientCreateService;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ApplicationFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private ClientCreateService $clientCreateService,
        private CarCreateService $carCreateService,
    ){}

    public function load(ObjectManager $manager)
    {
        $applications = [
            [
                'client' => [
                    "name" => "николай",
                    "patronomic" => "иванович",
                    "gender" => "MALE",
                    "phone" => ["79774100516", "79261669222"],
                    "dateOfBirth" => "1990-11-10 00:00:00",
                    "additional" => [],
                    "region" => $this->getReference("region-31"),
                ],
                'car' => [
                    [
                        "brand" => "KIA",
                        "model" => "Sorento",
                    ],
                    [
                        "brand" => "Suzuki",
                        "model" => "Jimny",
                        "equipment" => "Topline",
                        "transmission" => "front",
                        "engine" => "1.6",
                        "drive" => "",
                        "year" => 2018,
                        "color" => "Черный",
                        "price" => 3990990,
                        "tradeInPrice" => 3000000,
                        "tradeInOwnerPrice" => 3400000,
                        "isUsed" => true,
                        "additionalData" => "тест"
                    ],
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => true, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => true, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => true, "roofRails" => true, "yearWarranty" => false, "videoRecorder" => true, ],
                'attempts' => [],
                'source' => 'SITE',
                'reason' => 'NOTGOTOMOSCOW'
            ],
            [
                'client' => [
                    "name" => "Артём",
                    "gender" => "MALE",
                    "phone" => ["79031669291", "79261669222", "79251633221"],
                    "dateOfBirth" => "1990-11-10 00:00:00",
                    "additional" => [],
                    "region" => $this->getReference("region-1"),
                ],
                'car' => [
                    [
                        "brand" => "Haval",
                        "model" => "F7x",
                    ],
                    [
                        "brand" => "Nissan",
                        "model" => "Juke",
                        "equipment" => "Topline",
                        "transmission" => "front",
                        "engine" => "1.6",
                        "drive" => "",
                        "year" => 2018,
                        "color" => "Черный",
                        "price" => 3990990,
                        "tradeInPrice" => 3000000,
                        "tradeInOwnerPrice" => 3400000,
                        "isUsed" => true,
                        "additionalData" => "тест"
                    ],
                    [
                        "brand" => "Ssang Yong",
                        "model" => "Actyon",
                    ],
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => true, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => true, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => true, "roofRails" => true, "yearWarranty" => false, "videoRecorder" => true, ],
                'attempts' => [],
                'source' => 'STREET',
                'reason' => 'LTD'
            ],
            [
                'client' => [
                    "name" => "Иван",
                    "gender" => "MALE",
                    "surname" => "Иванов",
                    "phone" => ["79990001244", ],
                    "dateOfBirth" => "1990-11-10 00:00:00",
                    "additional" => [],
                ],
                'car' => [
                    [
                        "brand" => "Citroen",
                        "model" => "C5",
                        "equipment" => "Topline",
                        "transmission" => "front",
                        "engine" => "1.6",
                        "drive" => "",
                        "year" => 2018,
                        "color" => "Черный",
                        "price" => 3990990,
                        "tradeInPrice" => 3000000,
                        "tradeInOwnerPrice" => 3400000,
                        "isUsed" => true,
                        "additionalData" => "тест"
                    ],
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => true, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => true, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => true, "roofRails" => true, "yearWarranty" => false, "videoRecorder" => true, ],
                'attempts' => [],
                'source' => null,
                'reason' => null
            ],
            [
                'client' => [
                    "name" => "Фрол",
                    "surname" => "Петров",
                    "phone" => ["79991101233", ],
                    "gender" => "MALE",
                    "dateOfBirth" => "1987-11-10 00:00:00",
                    "additional" => [],
                ],
                'car' => [
                    [
                        "brand" => "BMW",
                        "model" => "X5",
                        "equipment" => "Topline",
                        "transmission" => "front",
                        "engine" => "3.0",
                        "drive" => "",
                        "year" => 2018,
                        "color" => "Черный",
                        "price" => 3990990,
                        "tradeInPrice" => 3000000,
                        "tradeInOwnerPrice" => 3400000,
                        "isUsed" => true,
                        "additionalData" => "тест"
                    ],
                ],
                'user' => $this->getReference("user-1"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => true, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => true, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => true, "roofRails" => true, "yearWarranty" => false, "videoRecorder" => true, ],
                'attempts' => [],
                'source' => null,
                'reason' => null
            ],
            [
                'client' => [
                    "name" => "Жмых",
                    "surname" => "Сидоров",
                    "phone" => ["79992221223"],
                    "gender" => "FEMALE",
                    "dateOfBirth" => "1988-04-30 00:00:00",
                    "additional" => [],
                ],
                'car' => [ 
                    [
                        "brand" => "Toyota",
                        "model" => "RAV4",
                        "equipment" => "Topline",
                        "transmission" => "front",
                        "engine" => "3.0",
                        "drive" => "",
                        "year" => 2018,
                        "color" => "Черный",
                        "price" => 3990990,
                        "tradeInPrice" => 3000000,
                        "tradeInOwnerPrice" => 3400000,
                        "isUsed" => true,
                        "additionalData" => "тест"
                    ]
                ],
                'user' => $this->getReference("user-3"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => true, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => true, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => true, "roofRails" => true, "yearWarranty" => false, "videoRecorder" => true, ],
                'attempts' => [],
                'source' => null,
                'reason' => null
            ],
            [
                'client' => [
                    "name" => "Леонид",
                    "surname" => "Ингиборге",
                    "phone" => ["79262221134"],
                    "gender" => "MALE",
                    "dateOfBirth" => "1989-07-24 00:00:00",
                    "additional" => [],
                ],
                'car' => [
                    [
                        "brand" => "KIA",
                        "model" => "K5",
                        "equipment" => "Topline",
                        "transmission" => "front",
                        "engine" => "3.0",
                        "drive" => "",
                        "year" => 2018,
                        "color" => "Черный",
                        "price" => 3990990,
                        "tradeInPrice" => 3000000,
                        "tradeInOwnerPrice" => 3400000,
                        "isUsed" => true,
                        "additionalData" => "тест"
                    ]
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => true, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => true, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => true, "roofRails" => true, "yearWarranty" => false, "videoRecorder" => true, ],
                'attempts' => [],
                'source' => null,
                'reason' => null
            ],
            [
                'client' => [
                    "name" => "Людмила",
                    "surname" => "Гунькина",
                    "patronic" => "Александровна",
                    "phone" => ["79058569329"],
                    "gender" => "FEMALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        "brand" => "Skoda",
                        "model" => "Rapid"
                    ]
                ],
                'user' => $this->getReference("user-3"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => true,
                'gift' => ["wheel" => false, "tires" => true, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => true, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => true, "roofRails" => true, "yearWarranty" => false, "videoRecorder" => true, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 2,
                        "success" => false,
                        "date" => "2020-08-19 22:00:12"
                    ],
                    [
                        "order" => 3,
                        "success" => false,
                        "date" => "2020-08-19 23:33:12"
                    ]
                ],
                'source' => "STREET",
                'reason' => null,
                'comments' => [
                    [
                        'text' => 'ПРИЕЗД 1ПД.ПВ 500К'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "АРМЕН",
                    "surname" => "АКЦЕНТ АВАГЯН",
                    "patronic" => "РУДОЛЬФОВИЧ",
                    "phone" => ["79645096933"],
                    "gender" => "MALE",
                    "additional" => [],
                ],
                'car' => [ 
                    [
                        "brand" => "Toyota",
                        "model" => "Camry",
                        "price" => 2573000,
                    ]
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => true,
                'gift' => ["wheel" => false, "tires" => true, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => true, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => true, "roofRails" => true, "yearWarranty" => false, "videoRecorder" => true, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 2,
                        "success" => false,
                        "date" => "2020-08-19 22:00:12"
                    ],
                    [
                        "order" => 3,
                        "success" => false,
                        "date" => "2020-08-19 23:33:12"
                    ],
                    [
                        "order" => 4,
                        "success" => false,
                        "date" => "2020-08-19 23:33:12"
                    ]
                ],
                'source' => "SITE",
                'reason' => null,
                'region' => 'г. Москва и Московская область',
                'comments' => [
                    [
                        'text' => 'ПРИЕЗД В БЛИЖ ДНИ'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "ибрагим",
                    "phone" => ["79660121357"],
                    "gender" => "MALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        "brand" => "Toyota",
                        "model" => "Camry",
                        "price" => 1804500,
                    ]
                ],
                'user' => $this->getReference("user-1"),
                'status' => $this->getReference("status-2"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => true,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 2,
                        "success" => false,
                        "date" => "2020-08-19 22:00:12"
                    ],
                    [
                        "order" => 3,
                        "success" => false,
                        "date" => "2020-08-19 23:33:12"
                    ],
                    [
                        "order" => 4,
                        "success" => false,
                        "date" => "2020-08-19 23:33:12"
                    ],
                    [
                        "order" => 5,
                        "success" => true,
                        "date" => "2020-08-19 23:33:12"
                    ]
                ],
                'source' => null,
                'reason' => null,
                'region' => 'г. Москва и Московская область',
                'comments' => [
                    [
                        'text' => 'НО'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "Мирзохит",
                    "phone" => ["79690104047"],
                    "gender" => "MALE",
                    "additional" => [],
                ],
                'car' => [],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-3"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => true,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 2,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 3,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 4,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => null,
                'region' => 'г. Москва и Московская область',
                'comments' => [
                    [
                        'text' => 'НО'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "Тушева",
                    "surname" => "Анна",
                    "patronic" => "Викторовна",
                    "phone" => ["79014505548"],
                    "gender" => "FEMALE",
                    "additional" => [],
                ],
                'car' => [],
                'user' => $this->getReference("user-3"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => 'NOTGOTOMOSCOW',
                'region' => 'г. Москва и Московская область',
                'comments' => [
                    [
                        'text' => 'мск нет'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "Инга",
                    "phone" => ["79279654155"],
                    "gender" => "FEMALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        'brand' => 'SsangYong',
                        'model' => 'Actyon',
                    ]
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-4"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => 'NOTGOTOMOSCOW',
                'region' => 'Республика Башкортостан',
                'comments' => [
                    [
                        'text' => 'мск нет'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "Дмитрий",
                    "phone" => ["79187482808", "79187482808"],
                    "gender" => "MALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        "brand" => "Honda",
                        "model" => "CR-V New",
                        "price" => 2645910,
                    ]
                ],
                'user' => $this->getReference("user-1"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => null,
                'region' => 'Ставропольский край',
                'comments' => [
                    [
                        'text' => 'ут решение'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "орзалиев",
                    "surname" => "шамиль",
                    "patronic" => "тхазреталиевич",
                    "phone" => ["79280094928"],
                    "gender" => "MALE",
                    "additional" => [],
                ],
                'car' => [],
                'user' => $this->getReference("user-3"),
                'status' => $this->getReference("status-4"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 2,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 3,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 4,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 5,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => 'NOTGOTOMOSCOW',
                'region' => 'Ставропольский край',
                'comments' => [
                    [
                        'text' => 'но'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "АРМЕН",
                    "surname" => "АКЦЕНТ АВАГЯН",
                    "patronic" => "РУДОЛЬФОВИЧ",
                    "phone" => ["79119581263"],
                    "gender" => "MALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        "brand" => "Lifan",
                        "model" => "X50",
                        "price" => 2573000,
                    ]
                ],
                'user' => $this->getReference("user-3"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => true,
                'gift' => ["wheel" => false, "tires" => true, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => true, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => true, "roofRails" => true, "yearWarranty" => false, "videoRecorder" => true, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 2,
                        "success" => false,
                        "date" => "2020-08-19 22:00:12"
                    ],
                    [
                        "order" => 3,
                        "success" => false,
                        "date" => "2020-08-19 23:33:12"
                    ],
                    [
                        "order" => 4,
                        "success" => false,
                        "date" => "2020-08-19 23:33:12"
                    ]
                ],
                'source' => null,
                'reason' => 'NOTGOTOMOSCOW',
                'region' => 'г. Санкт-Петербург и Ленинградская область',
                'comments' => [
                    [
                        'text' => 'ПРИЕЗД В БЛИЖ ДНИ'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "Наталья",
                    "surname" => "Синожацкая",
                    "phone" => ["79892646225"],
                    "gender" => "FEMALE",
                    "additional" => [],
                ],
                'car' => [],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-4"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => true, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => true, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => true, "roofRails" => true, "yearWarranty" => false, "videoRecorder" => true, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                "region" => "Краснодарский край",
                'source' => "STREET",
                'reason' => null,
                'comments' => [
                    [
                        'text' => 'ПРИЕЗД 1ПД.ПВ 500К'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "райля",
                    "surname" => "гайнуллина",
                    "patronic" => "рафкатовна",
                    "phone" => ["79270831225"],
                    "gender" => "FEMALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        "brand" => "Datsun",
                    ]
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-4"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => 'NOTGOTOMOSCOW',
                'region' => 'Республика Башкортостан',
                'comments' => [
                    [
                        'text' => 'мск нет'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "СПАРТАК",
                    "surname" => "МЧЕДЛИШВИЛИ",
                    "patronic" => "ЛЕРИЕВИЧ",
                    "phone" => ["79774841198"],
                    "gender" => "MALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        "brand" => "Toyota",
                        "model" => "Camry",
                        "price" => 1636200,
                    ]
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-3"),
                'additionalCar' => [
                    [
                        "brand" => "Toyota",
                        "model" => "Camry",
                        "tradeInPrice" => 400000,
                    ],
                ],
                'tradeIn' => true,
                'isCredit' => true,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 2,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 3,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 4,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => null,
                'region' => 'г. Москва и Московская область',
                'comments' => [
                    [
                        'text' => 'ут решение'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "Игорь",
                    "phone" => ["79268500156"],
                    "gender" => "MALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        'brand' => 'Hyundai',
                        'model' => 'Solaris',
                        'price' => 954900,
                        'tradeInPrice' => 250000,
                        'additionalData' => 'Comfort 1.6 AT 123 л.с. 1 061 000 руб. 106 100 руб. 954 900 руб белый, чёрный, серебристый',
                    ]
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => true,
                'isCredit' => true,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => null,
                'region' => 'г. Москва и Московская область',
                'comments' => [
                    [
                        'text' => 'мск нет'
                    ]
                ],
            ],
            [
                'client' => [
                    "phone" => ["79265372907"],
                    "gender" => "MALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        "brand" => "Lada",
                        "model" => "Vesta",
                    ]
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => true,
                'isCredit' => false,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 2,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 3,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 4,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => null,
                'region' => 'г. Москва и Московская область',
                'comments' => [
                    [
                        'text' => 'сам перезвонит'
                    ]
                ],
            ],
            [
                'client' => [
                    "phone" => ["79055159655"],
                    "gender" => "MALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        'brand' => 'Kia',
                        'model' => 'Rio',
                    ]
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-4"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => 'NOTRELEVANT',
                'region' => 'г. Москва и Московская область',
                'comments' => [
                    [
                        'text' => 'Не актуально'
                    ]
                ],
            ],
            [
                'client' => [
                    "phone" => ["78165722966"],
                    "gender" => "FEMALE",
                    "additional" => [],
                ],
                'car' =>[
                    [
                        'brand' => 'Toyota',
                        'model' => 'RAV4',
                        'price' => 1434590,
                    ]
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [],
                'tradeIn' => false,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => 'NOTGOTOMOSCOW',
                'region' => 'Новгородская обл.',
                'comments' => [
                    [
                        'text' => 'мск нет'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "Сергей",
                    "phone" => ["79277671697"],
                    "gender" => "MALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        "brand" => "Shkoda",
                        "model" => "Rapid",
                        "price" => 1636200,
                    ]
                ],
                'additionalCar' => [],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-3"),
                'tradeIn' => true,
                'isCredit' => true,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 2,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 3,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 4,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => null,
                'region' => 'Самарская обл.',
                'comments' => [
                    [
                        'text' => 'ут решение'
                    ]
                ],
            ],
            [
                'client' => [
                    "name" => "Екатерина",
                    "phone" => ["79686030758"],
                    "gender" => "FEMALE",
                    "additional" => [],
                ],
                'car' => [
                    [
                        'brand' => 'Lada',
                        'model' => 'Granta New',
                        'price' => 954900,
                        'tradeInPrice' => 250000,
                        'additionalData' => 'Comfort 1.6 AT 123 л.с. 1 061 000 руб. 106 100 руб. 954 900 руб белый, чёрный, серебристый',
                    ]
                ],
                'user' => $this->getReference("user-2"),
                'status' => $this->getReference("status-1"),
                'additionalCar' => [
                    [
                        'brand' => 'Lada',
                        'model' => 'Granta Универсал New',
                        'price' => 954900,
                        'tradeInPrice' => 250000,
                        'additionalData' => 'Comfort 1.6 AT 123 л.с. 1 061 000 руб. 106 100 руб. 954 900 руб белый, чёрный, серебристый',
                    ],
                ],
                'tradeIn' => true,
                'isCredit' => null,
                'gift' => ["wheel" => false, "tires" => false, "towbar" => false, "alarm" => false, "thresholds" => false, "travelSet" => false, "petrolTank" => false, "registration" => false, "travel" => false, "color" => true, "insurance" => false, "anticorrosiveProtection" => false, "roofRails" => false, "yearWarranty" => true, "videoRecorder" => false, ],
                'attempts' => [
                    [
                        "order" => 1,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 2,
                        "success" => false,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                    [
                        "order" => 3,
                        "success" => true,
                        "date" =>"2020-08-19 00:00:12"
                    ],
                ],
                'source' => null,
                'reason' => null,
                'region' => 'г. Москва и Московская область',
                'comments' => [
                    [
                        'text' => 'Приехали сравнить два авто'
                    ]
                ],
            ],
        ];

        $i = 0;
        foreach ($applications as $i => $application) {
            $i++;
            $attempts = [
                ["order" => 1, "success" => null, "date" => null, ],
                ["order" => 2, "success" => null, "date" => null, ],
                ["order" => 3, "success" => null, "date" => null, ],
                ["order" => 4, "success" => null, "date" => null, ],
                ["order" => 5, "success" => null, "date" => null, ],
            ];
            $applicationItem = new Application(
                isset($application['actionAt']) ? new DateTime($application['actionAt']) : new DateTime('+15 minutes'),
                null,
                $this->userRepository->find($application['user'])->getDealer(),
                ($this->clientCreateService)($application['client']),
                $this->userRepository->find($application['user']),
                null,
                array_map(
                    fn($carData) => ($this->carCreateService)($carData), 
                    $application['car']
                ),
                Type::get('MANUAL'),
                $application['status'],
                $application['isCredit'],
                $application['tradeIn'],
                (array)$application['attempts'] + $attempts,
                $application['gift'],
                Source::get($application['source']),
                Reason::get($application['reason']),
                false
            );
            $this->setReference("application-{$i}", $applicationItem);
            $manager->persist($applicationItem);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StatusFixture::class,
            RegionFixture::class,
            UserFixture::class,
        ];
    }
}
