<?php
namespace App\Service\Application;

use App\Repository\UserRepository;
use App\Service\JWT\CreateTokenService;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class ApplicationStatisticService {
    public function __construct() {}

    public function __invoke(Request $request): array
    {
        return [];
    }
}