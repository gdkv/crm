<?php

namespace App\Controller\Auth;

use App\Controller\JsonResponseTrait;
use App\Controller\RoleTrait;
use App\Entity\User;
use App\Service\Auth\LoginService;
use App\Service\User\UserGetService;
use App\Service\User\UserListService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;

class ListController extends AbstractController
{
    use JsonResponseTrait; 
    use RoleTrait;

    public function __construct(
        private SerializerInterface $serializer,
        private UserListService $userListService,
    ){}


    #[Route('/auth/list', name: 'auth.list', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted("USERS_VIEW");
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: "access_denied", code: "Недостаточно прав", httpCode: 403);
        }

        $users = ($this->userListService)();
        if (!$users) {
            return $this->jsonResponseError(
                message: "Users not found", 
                code: 'users_not_found',
                httpCode: 401
            );
        }

        return $this->jsonResponse($users);
    }

}
