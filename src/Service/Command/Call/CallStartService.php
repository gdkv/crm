<?php
namespace App\Service\Command\Call;

use App\Entity\User;
use Epictest\MangoVpbx\MangoOffice\Call;

class CallStartService {

    private Call $mangoVpbx;

    public function __construct(
        private string $masMangoKey,
        private string $masMangoSalt,
    ){
        $this->mangoVpbx = new Call($this->masMangoKey, $this->masMangoSalt);
    }

    public function __invoke()
    {
        return $this->mangoVpbx->sendCall(to:"79268606949", from: "666");
    }

    
}