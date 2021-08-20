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
        private ApplicationAddService $applicationAddService,
    ){
        $this->serializer = new Serializer([new ObjectNormalizer(), ]);
    }

    public function __invoke(Request $request): array
    {
        $request->request = new InputBag($request->toArray());

        $applicationData = [
            'client' => $request->request->all('client'),
            'car' => $request->request->all('car'),
            'user' => $this->security->getUser(),
            'status' => $request->request->get('status'),
            'additionalCar' => $request->request->all('additionalCars'),
            'tradeIn' => $request->request->get('isTradeIn', false),
            'gift' => $request->request->all('gift'),
            'attempts' => $request->request->all('attempts'),
            'source' => $request->request->get('source'),
            'reason' => $request->request->get('reason')
        ];
        if($request->request->has('actionAt'))
            $applicationData['actionAt'] = $request->request->get('actionAt');
        if($request->request->has('isCredit'))
            $applicationData['isCredit'] = $request->request->get('isCredit');
        else 
            $applicationData['isCredit'] = null;

        $application = ($this->applicationAddService)($applicationData);

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