<?php

namespace App\Controller\Command\Call;

use App\Controller\JsonResponseTrait;
use App\Service\Command\Call\CallStartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;


class CallGetController extends AbstractController
{  
    use JsonResponseTrait;

    public function __construct(
        private HubInterface $hub,
    ){}

    #[Route('/api/command/call/get', name: 'command.call.get', methods: ['GET', 'POST'])]
    public function __invoke()
    {
        // $response = ($this->callStartService)();
        $update = new Update(
            '/test',
            json_encode(['status' => 'OutOfStock'])
        );

        $this->hub->publish($update);

        return $this->jsonResponse(['status' => 'ok']);
    } 

}
