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
use App\Service\Application\Car\CarUpdateService;
use App\Service\Application\Client\ClientCreateService;
use App\Service\Application\Client\ClientUpdateService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApplicationUpdateService {

    private Serializer $serializer;

    public function __construct(
        private Security $security,
        private UserRepository $userRepository,
        private CarRepository $carRepository,
        private EntityManagerInterface $em,
        private ClientUpdateService $clientUpdateService,
        private CarUpdateService $carUpdateService,
    ){
        $this->serializer = new Serializer([new ObjectNormalizer(), ]);
    }

    public function __invoke(Request $request, Application $application): Application
    {
        $request->request = new InputBag($request->toArray());

        $applicationData = [
            'actionAt' => new DateTime($request->request->get('actionAt', 'now')),
            'client' => $request->request->all('client'),
            'car' => $request->request->all('car'),
            'operator' => $request->request->all('operator'),
            'status' => $request->request->get('status'),
            'additionalCar' => $request->request->all('additionalCars'),
            'isCredit' => $request->request->get('isCredit', null),
            'tradeIn' => $request->request->get('isTradeIn', false),
            'gift' => $request->request->all('gift'),
            'attempts' => $request->request->all('attempts'),
            'source' => $request->request->get('source'),
            'reason' => $request->request->get('reason')
        ];

        $client = ($this->clientUpdateService)($applicationData['client'], $application->getClient());
        $car = ($this->carUpdateService)($applicationData['car'], $application->getCar());
        $operator = $this->userRepository->find($applicationData['operator']['id']);

        // $application->setPushedAt(new DateTime('now'));
        $application->setActionAt($applicationData['actionAt']);
        $application->setStatus(ApplicationStatus::get($applicationData['status']));
        $application->setClient($client);
        $application->setOperator($operator);
        $application->setCar($car);

        array_map(
            fn($carData) => $application->addAdditionalCar(
                ($this->carUpdateService)(
                    carData: $carData,
                    car: (isset($carData['id']) ? $this->carRepository->find($carData['id']) : null)
                ),
            ), 
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