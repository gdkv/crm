<?php
namespace App\Service\Application;

use App\Entity\Application\Application;
use App\Entity\Application\Car;
use App\Model\Enum\ApplicationStatus;
use App\Model\Enum\Reason;
use App\Model\Enum\Source;
use App\Model\Enum\Type;
use DateTime;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use App\Service\Application\Car\CarCreateService;
use App\Service\Application\Client\ClientCreateService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApplicationAddService {

    private Serializer $serializer;

    public function __construct(
        private Security $security,
        private UserRepository $userRepository,
        private CarRepository $carRepository,
        private EntityManagerInterface $em,
        private ClientCreateService $clientCreateService,
        private CarCreateService $carCreateService,
    ){
        $this->serializer = new Serializer([new ObjectNormalizer(), ]);
    }

    public function __invoke(array $applicationData): Application
    {
        $client = ($this->clientCreateService)($applicationData['client']);
        $car = ($this->carCreateService)($applicationData['car']);
        $user = $this->userRepository->find($applicationData['user']);

        $application = new Application();

        $application->setPushedAt(new DateTime('now'));
        $application->setActionAt(isset($applicationData['actionAt']) ? new DateTime($applicationData['actionAt']) : new DateTime('+15 minutes'));
        $application->setDealer($user->getDealer());
        $application->setType(Type::get('MANUAL'));
        $application->setStatus(ApplicationStatus::get($applicationData['status']));
        $application->setClient($client);
        $application->setOperator($user);
        $application->setCar($car);
        array_map(
            fn($carData) => $application->addAdditionalCar(($this->carCreateService)($carData)), 
            $applicationData['additionalCar']
        );

        $application->setIsCredit($applicationData['isCredit']);
        $application->setIsTradeIn($applicationData['tradeIn']);
        $application->setGift($applicationData['gift']);
        $application->setAttempts($applicationData['attempts']);
        $application->setSource(Source::get($applicationData['source']));
        $application->setReason(Reason::get($applicationData['reason']));

        return $application;
    }
}