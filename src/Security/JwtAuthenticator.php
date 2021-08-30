<?php

namespace App\Security;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use UnexpectedValueException;

class JwtAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private string $trustedIp,
        private EntityManagerInterface $em, 
        private ContainerBagInterface $params, 
        private LoggerInterface $logger,
        private UserRepository $userRepository
    ){}

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $apiToken = str_replace('Bearer ', '', $request->headers->get('Authorization'));
        $jwt = [];

        if (null === $apiToken) {
            throw new CustomUserMessageAuthenticationException(message: 'token_not_found');
        }

        try {
            $jwt = (array) JWT::decode($apiToken, $this->params->get('jwt_secret'), ['HS256']);
        } catch (UnexpectedValueException $e) {
            throw new CustomUserMessageAuthenticationException(message: 'wrong_token');
        } catch (DomainException $e) {
            throw new CustomUserMessageAuthenticationException(message: 'internal_error');
        }

        $currentUser = $this->userRepository->findOneBy(['username' => $jwt['username']]);

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


        return new SelfValidatingPassport(
            new UserBadge($jwt['username'], function ($userIdentifier) {
                return $this->userRepository->findOneBy(['username' => $userIdentifier]);
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(
            ['message' => $exception->getMessage()], 
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function start(Request $request, AuthenticationException $authException = null): JsonResponse
    {
        return new JsonResponse(
            ['message' => 'Authentication Required'], 
            Response::HTTP_UNAUTHORIZED
        );
    }
}
