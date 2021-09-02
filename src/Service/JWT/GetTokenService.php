<?php 
namespace App\Service\JWT;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class GetTokenService {
    public function __construct(
    ){}

    public function __invoke(Request $request): string
    {
        $apiToken = "";
        $apiToken = str_replace('Bearer ', '', $request->headers->get('Authorization'));

        if (null === $apiToken) {
            throw new CustomUserMessageAuthenticationException(message: 'token_not_found');
        }
        return $apiToken;
    }
    
}