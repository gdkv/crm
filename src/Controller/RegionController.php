<?php

namespace App\Controller;

use App\Entity\Dealer;
use App\Repository\DealerRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/region', name: 'region.')]
class RegionController extends AbstractController
{
    use JsonResponseTrait;

    public function __construct(
        private RegionRepository $regionRepository,
        private SerializerInterface $serializer,
    ){}

    #[Route('', name: 'list')]
    public function index(): Response
    {
        try {
            $this->denyAccessUnlessGranted('APPLICATION_VIEW');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для просмотра", code: 'access_denied');
        }

        return $this->jsonResponse($this->regionRepository->findAll());
    }
}
