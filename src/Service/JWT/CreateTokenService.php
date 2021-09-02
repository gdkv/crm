<?php 
namespace App\Service\JWT;

use App\Entity\User;
use DateTime;
use Firebase\JWT\JWT;

class CreateTokenService {
    public function __construct(
        private string $jwtSecret,
    ){}

    public function __invoke(User $user): array
    {
        $lifeTime = (new DateTime())->modify("+6 hours");
        $jwt = JWT::encode(
            [
                "username" => $user->getUserIdentifier(),
                "expiresAt" => $lifeTime->getTimestamp(),
            ], 
            $this->jwtSecret
        );

        return ['jwt' => $jwt, 'expiresAt' => $lifeTime, ];
    }
    
}