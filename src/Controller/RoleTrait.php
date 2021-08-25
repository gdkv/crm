<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

trait RoleTrait
{
    private function roleCheckAccess(string $role="", string $errorCode="", string $infoMessage="")
    {
        print(1111);
        
        try {
            $this->denyAccessUnlessGranted($role);
        } catch (AccessDeniedException $e) {
            return $this->jsonResponseError(message: $infoMessage, code: $errorCode);
        }
    }
}