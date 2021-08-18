<?php

namespace App\Controller;

use App\Entity\Dealer;
use App\Repository\DealerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/dealer', name: 'dealer.')]
class DealerController extends AbstractController
{
    public function __construct(
        private DealerRepository $dealerRepository
    ){}

    #[Route('', name: 'list')]
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok', 
            'data' => $this->dealerRepository->findArray()
        ]);
    }

    #[Route('/{id}', name: 'view')]
    public function view(Dealer $dealer): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok', 
            'data' => $dealer->jsonSerialize()
        ]);
    }
}
