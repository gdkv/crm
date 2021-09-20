<?php

namespace App\Controller;

use App\Entity\Application\Car;
use App\Entity\Dealer;
use App\Repository\CarRepository;
use App\Repository\DealerRepository;
use App\Service\Application\Car\CarCreateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

#[Route('/api/car', name: 'car.')]
class CarController extends AbstractController
{
    use JsonResponseTrait;

    public function __construct(
        private CarRepository $carRepository,
        private SerializerInterface $serializer,
    ){}

    #[Route('', name: 'list', methods: ['GET'])]
    public function index(Request $request): Response
    {
        try {
            $this->denyAccessUnlessGranted('CAR_VIEW');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "Недостаточно прав для просмотра", code: 'access_denied');
        }

        $filters = [
            'type' => $request->query->get('type', 'brands'),
            'brand' => $request->query->get('brand', null),
        ];

        return $this->jsonResponse($this->carRepository->findDistinctBrands($filters));
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function add(Request $request, CarCreateService $carCreateService): Response
    {
        try {
            $this->denyAccessUnlessGranted('CAR_ADD');
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(
                message: "Недостаточно прав для добавления", 
                code: 'access_denied', 
                httpCode: 401
            );
        }

        try {
            $request->request = new InputBag($request->toArray());
            $carData = [
                'brand' => $request->request->get('brand'),
                'model' => $request->request->get('model'),
            ];
            $car = ($carCreateService)($carData);
        } catch (Throwable $e) {
            return $this->jsonResponseError(message: $e->getMessage(), code: 'pdo_error');
        }

        return $this->jsonResponse($car);
    }
}
