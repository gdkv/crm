<?php
namespace App\Service\Application\Client;

use App\Entity\Application\Client;
use App\Entity\User;
use App\Model\Enum\Gender;
use App\Model\Enum\Status;
use App\Repository\DealerRepository;
use App\Repository\RegionRepository;
use App\Repository\UserRepository;
use App\Service\JWT\CreateTokenService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientCreateService {
    public function __construct(
        private CreateTokenService $createTokenService,
        private UserRepository $userRepository,
        private RegionRepository $regionRepository,
        private UserPasswordHasherInterface $encoder, 
        private DealerRepository $dealerRepository,
        private EntityManagerInterface $em,
    ) {}

    public function __invoke(array $clientData): Client
    {
        $clientDataAdditional = isset($clientData['additional']) ? $clientData['additional'] : [];

        $client = new Client();

        $client->setName(isset($clientData['name']) ? $clientData['name'] : null);
        $client->setSurname(isset($clientData['surname']) ? $clientData['surname'] : null);
        $client->setPatronymic(isset($clientData['patronymic']) ? $clientData['patronymic'] : null);
        $client->setPhone($clientData['phone']);
        $client->setDateOfBirth(isset($clientData['dateOfBirth']) ? new DateTime($clientData['dateOfBirth']) : null);
        $client->setAdditional($clientDataAdditional);
        
        if(isset($clientData['region']['id'])){
            $region = $this->regionRepository->find($clientData['region']['id']);
            $client->setRegion($region);
        }

        if ($clientData['gender'])
            $client->setGender(Gender::get($clientData['gender']));

        $this->em->persist($client);
        $this->em->flush();


        return $client;
    }
}