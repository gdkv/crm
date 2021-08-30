<?php

namespace App\Controller;

use App\Entity\Dealer;
use App\Repository\DealerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/dealer', name: 'dealer.')]
class DealerController extends AbstractController
{
    use JsonResponseTrait;

    public function __construct(
        private DealerRepository $dealerRepository,
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

        return $this->jsonResponse($this->dealerRepository->findAll());
    }

    #[Route('/{id}', name: 'view')]
    public function view(?Dealer $dealer): Response
    {
        try {
            $this->denyAccessUnlessGranted('APPLICATION_VIEW');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для просмотра", code: 'access_denied');
        }
        
        if(!$dealer) {
            return $this->jsonResponseError(
                message: 'Dealer not found', 
                code: 'dealer_not_found', 
                httpCode: 404
            );
        }

        return $this->jsonResponse($dealer);
    }
}
