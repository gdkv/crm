<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api.')]
class MainController extends AbstractController
{
    #[Route('', name: 'main')]
    public function index(): JsonResponse
    {
        return new JsonResponse(['status' => 'ok', 'data' => [], ]);
    }
}
