<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/application', name: 'application.')]
class ApplicationController extends AbstractController
{
    #[Route('', name: 'list')]
    public function index(Request $request): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
            'data' => [],
        ]);
    }
}
