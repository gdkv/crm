<?php

namespace App\Controller\Command\Call;

use App\Controller\JsonResponseTrait;
use App\Service\Command\Call\CallStartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;


class CallStartController extends AbstractController
{  
    use JsonResponseTrait;
    
    public function __construct(
        private CallStartService $callStartService,
        private SerializerInterface $serializer,
    ){}

    #[Route('/api/command/call/start', name: 'command.call.start', methods: ['GET', 'POST'])]
    public function __invoke()
    {
        // try {
        //     $this->denyAccessUnlessGranted('CALL_START');
        // } catch (AccessDeniedException $e) {
        //     return $this->jsonResponseError(
        //         message: "Недостаточно прав для выполнения комманды", 
        //         code: 'access_denied', 
        //         httpCode: 401
        //     );
        // }

        // try {
            $data = ($this->callStartService)();
        // } catch (Throwable $e) {
            // return $this->jsonResponseError(message: $e->getMessage(), code: 'pdo_error');
        // }

        return $this->jsonResponse($data);
    } 

}
