<?php

namespace App\Entity\Credit;

use App\Entity\EntityIdTrait;
use App\Entity\User;
use App\Repository\CreditRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreditRepository::class)
 */
class Credit
{
    use EntityIdTrait;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="creditManager")
     * @ORM\JoinColumn(nullable=true)
     */
    private User $manager;

}
