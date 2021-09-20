<?php
namespace App\Service\Command\Call;

use App\Entity\User;

class CallStartService {

    public function __construct(
        private string $mangoApiRiaKey,
        private string $mangoApiRiaSalt,
        private string $mangoApiMasKey,
        private string $mangoApiMasSalt,
    ){}

    public function __invoke(string $phone, User $operator): ?array
    {
        // $operator
        return [];
    }

    
}