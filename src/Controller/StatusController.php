<?php

namespace App\Controller;

use App\Entity\Dealer;
use App\Repository\DealerRepository;
use App\Repository\RegionRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/status', name: 'status.')]
class StatusController extends AbstractController
{
    use JsonResponseTrait;

    public function __construct(
        private StatusRepository $statusRepository,
        private SerializerInterface $serializer,
    ){}

    #[Route('', name: 'list')]
    public function __invoke(): Response
    {
        try {
            $this->denyAccessUnlessGranted('APPLICATION_VIEW');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для просмотра", code: 'access_denied');
        }

        return $this->jsonResponse($this->statusRepository->findAll());
    }
}
