<?php
namespace App\Service\User;

use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class UserCheckAccessService {
    public function __construct(
        private string $trustedIp,
        private UserRepository $userRepository,
    ) {}

    public function __invoke(Request $request, string $username = ""): void
    {
        $currentUser = $this->userRepository->findOneBy(['username' => $username]);

        if (!$currentUser->getIsRemote()){
            $trustedIpArray = explode(',', $this->trustedIp);
            $ip = $request->getClientIp();
            if (!in_array($ip, $trustedIpArray))
                throw new CustomUserMessageAuthenticationException(
                    message: 'сlient_not_at_whitelist', 
                    messageData: ['client IP' => $request->getClientIp(), ], 
                    code: 403,
                );
        }

        if ($currentUser->getExpiresAt() && ((new DateTime("now")) > $currentUser->getExpiresAt())) {
            throw new CustomUserMessageAuthenticationException(
                message: 'access_is_expired',
                messageData: ['expires' => $currentUser->getExpiresAt(), ],
                code: 403,
            );
        }
    }
}