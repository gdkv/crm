<?php
namespace App\Service\Application;

use App\Entity\Application\Application;
use App\Model\DTO\ApplicationDTO;
use App\Model\Enum\ApplicationStatus;
use App\Model\Enum\Reason;
use App\Model\Enum\Source;
use App\Model\Enum\Type;
use App\Repository\CarRepository;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
use App\Service\Application\Car\CarCreateService;
use App\Service\Application\Client\ClientCreateService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ApplicationCreateService {

    public function __construct(
        private Security $security,
        private EntityManagerInterface $em,
        private CarRepository $carRepository,
        private UserRepository $userRepository,
        private SerializerInterface $serializer,
        private CarCreateService $carCreateService,
        private StatusRepository $statusRepository,
        private ClientCreateService $clientCreateService,
    ){
        $this->serializer = new Serializer([new ObjectNormalizer(), ]);
    }

    public function __invoke(Request $request): Application
    {

        $applicationDTO = ApplicationDTO::resolver($request);
        $manager = null;
        $client = ($this->clientCreateService)($applicationDTO->getClient());
        $status = $this->statusRepository->findOneBy([
            'status' => ApplicationStatus::get($applicationDTO->getStatus()),
        ]);
        
        if ($applicationDTO->getOperator()) {
            $operator = $this->userRepository->find($applicationDTO->getOperator());
        } else {
            $operator = $this->userRepository->findOneBy(['username' => $this->security->getUser()->getUserIdentifier()], []);
        }
        
        if ($applicationDTO->getManager())
            $manager = $this->userRepository->find($applicationDTO->getManager());

        $application = new Application(
            $applicationDTO->getActionAt(),
            $applicationDTO->getArrivedAt(),
            $operator->getDealer(),
            $client,
            $operator,
            $manager,
            array_map(
                fn($carData) => ($this->carCreateService)($carData), 
                $applicationDTO->getCar()
            ),
            Type::get($applicationDTO->getType()),
            $status,
            $applicationDTO->getIsCredit(),
            $applicationDTO->getIsTradeIn(),
            $applicationDTO->getAttempts(),
            $applicationDTO->getGift(),
            Source::get($applicationDTO->getSource()),
            Reason::get($applicationDTO->getReason()),
            $applicationDTO->getIsProcessed(),
        );

        $this->em->persist($application);
        $this->em->flush();

        return $application;
    }
}