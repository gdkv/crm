<?php
namespace App\Service\Application;

use App\Entity\Application\Application;
use App\Entity\Application\Car;
use App\Model\DTO\ApplicationDTO;
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
        $applicationDTO = ApplicationDTO::resolver($request);
        $manager = null;
        $client = ($this->clientUpdateService)($applicationDTO->getClient(), $application->getClient());
        
        if ($applicationDTO->getOperator()) {
            $operator = $this->userRepository->find($applicationDTO->getOperator());
        } else {
            $operator = $this->userRepository->findOneBy(['username' => $this->security->getUser()->getUserIdentifier()], []);
        }
        
        if ($applicationDTO->getManager())
            $manager = $this->userRepository->find($applicationDTO->getManager());

        

        $application->update(
            $applicationDTO->getActionAt(),
            $applicationDTO->getArrivedAt(),
            $operator->getDealer(),
            $client,
            $operator,
            $manager,
            array_map(
                fn($carData) => ($this->carUpdateService)(
                    carData: $carData,
                    car: (isset($carData['id']) ? $this->carRepository->find($carData['id']) : null)
                ),
                $applicationDTO->getCar()
            ),
            Type::get($applicationDTO->getType()),
            ApplicationStatus::get($applicationDTO->getStatus()),
            $applicationDTO->getIsCredit(),
            $applicationDTO->getIsTradeIn(),
            $applicationDTO->getAttempts(),
            $applicationDTO->getGift(),
            Source::get($applicationDTO->getSource()),
            Reason::get($applicationDTO->getReason()),
            $applicationDTO->getIsProcessed(),
        );

        $this->em->flush();

        return $application;
    }
}