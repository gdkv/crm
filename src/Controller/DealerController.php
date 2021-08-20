<?php

namespace App\Controller;

use App\Entity\Dealer;
use App\Repository\DealerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/dealer', name: 'dealer.')]
class DealerController extends AbstractController
{
    public function __construct(
        private DealerRepository $dealerRepository
    ){}

    #[Route('', name: 'list')]
    public function index(): Response
    {
        return $this->json([
            'status' => 'ok', 
            'data' => $this->dealerRepository->findArray()
        ]);
    }

    #[Route('/{id}', name: 'view')]
    public function view(Dealer $dealer): Response
    {
        return $this->json([
            'status' => 'ok', 
            'data' => $dealer
        ]);
    }
}
