<?php
namespace App\Service\Application;

use DateTime;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Uid\UuidV6;

class ApplicationFilterService {
    public function __construct(
        private Security $security,
        private UserRepository $userRepository,
        private CarRepository $carRepository,
    ){}

    public function __invoke(Request $request): array
    {
        $filters = [];

        $operator = $request->query->get('operator');
        if($operator) {
            $filters['operator'] = $this->userRepository->find($operator);
        } else {
            $filters['operator'] = $this->userRepository->findOneBy([
                'username' => $this->security->getUser()->getUserIdentifier(),
            ]);
        }


        $date = $request->query->get('date');
        if($date) {
            $filters['date'] = new DateTime($date);
        } else {
            $filters['date'] = new DateTime("now");
        }


        if ($request->query->has('client'))
            $filters['client'] = $request->query->get('client');
        
        if ($request->query->has('phone'))
            $filters['phone'] = $request->query->get('phone');

        if($request->query->has('car')) {
            $filters['car']= $this->carRepository->find($request->query->get('car'));
        }

        return $filters;
    }
}