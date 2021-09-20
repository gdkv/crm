<?php
namespace App\Service\Application\Comment;

use App\Entity\Application\Application;
use App\Entity\Application\Comment;
use App\Model\DTO\ApplicationDTO;
use App\Model\DTO\CommentDTO;
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

class CommentCreateService {

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

    public function __invoke(CommentDTO $commentDTO): Comment
    {

        $comment = new Comment(
            $commentDTO->getText(),
            $commentDTO->getOperator()
        );

        $this->em->persist($comment);
        $this->em->flush();

        return $comment;
    }
}