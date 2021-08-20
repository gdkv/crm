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

class ApplicationCreateService {

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

    public function __invoke(Request $request): array
    {
        $request->request = new InputBag($request->toArray());

        $client = ($this->clientCreateService)($request->request->all('client'));
        $car = ($this->carCreateService)($request->request->all('car'));
        $user = $this->userRepository->find($this->security->getUser());

        $application = new Application();

        $application->setPushedAt(new DateTime('now'));
        $application->setActionAt(new DateTime('now'));
        $application->setDealer($user->getDealer());
        $application->setType(Type::get('MANUAL'));
        $application->setStatus(ApplicationStatus::get($request->request->get('status')));
        $application->setClient($client);
        $application->setOperator($user);
        $application->setCar($car);
        array_map(
            fn($carData) => $application->addAdditionalCar(($this->carCreateService)($carData)), 
            $request->request->all('additionalCars')
        );
        if($request->request->has('isCredit'))
        $application->setIsCredit($request->request->get('isCredit'));
        $application->setIsTradeIn($request->request->get('isTradeIn', false));
        $application->setGift($request->request->all('gift'));
        $application->setAttempts($request->request->all('attempts'));
        $application->setSource(Source::get($request->request->get('source')));
        $application->setReason(Reason::get($request->request->get('reason')));
        
        $this->em->persist($application);
        $this->em->flush();

        return [
            'status' => 'ok', 
            'data' => [
                "application" => $application->jsonSerialize()
            ],
        ];
    }
}