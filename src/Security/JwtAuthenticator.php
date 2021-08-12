<?php

namespace App\Security;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Firebase\JWT\JWT;
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

class JwtAuthenticator extends AbstractAuthenticator
{
    public function __construct(
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

        if (null === $apiToken) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        $jwt = (array) JWT::decode(
            $apiToken, 
            $this->params->get('jwt_secret'),
            ['HS256']
        );

        $this->logger->info("jwt ", ["data" => $jwt]);

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
