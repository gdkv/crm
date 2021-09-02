<?php

namespace App\Entity\Credit;

use App\Entity\EntityIdTrait;
use App\Repository\CreditFormRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreditFormRepository::class)
 * @ORM\Table(name="`credit_form`")
 * @ORM\HasLifecycleCallbacks
 */
class CreditForm
{
    use EntityIdTrait;
    

}
