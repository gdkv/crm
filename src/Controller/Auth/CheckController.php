<?php

namespace App\Controller\Auth;

use App\Controller\JsonResponseTrait;
use App\Controller\RoleTrait;
use App\Entity\User;
use App\Service\Auth\LoginService;
use App\Service\User\UserCheckUsernameService;
use App\Service\User\UserGetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class CheckController extends AbstractController
{
    use JsonResponseTrait; 
    use RoleTrait;

    public function __construct(
        private SerializerInterface $serializer,
        private UserCheckUsernameService $userCheckUsernameService,
    ){}


    #[Route('/auth/check', name: 'auth.check', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted("USERS_CHECK");
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "access_denied", code: "Недостаточно прав", httpCode: 403);
        }

        try{
            $request->request = new InputBag($request->toArray());
        } catch (JsonException $e) {
            return $this->jsonResponseError(message: $e, code: 'json_invalid', httpCode: 500);
        }

        $userName = $request->request->get('username');

        if (!$userName) {
            return $this->jsonResponseError(message: "Username is incorrect", code: 'username_is_incorrect', httpCode: 401 );
        }

        return $this->jsonResponse(($this->userCheckUsernameService)($userName));
    }

}
