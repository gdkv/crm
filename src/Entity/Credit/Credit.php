<?php

namespace App\Entity\Credit;

use App\Entity\EntityIdTrait;
use App\Entity\User;
use App\Model\Enum\CreditStatus;
use App\Repository\CreditRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CreditRepository::class)
 * @ORM\Table(name="`credit`")
 * @ORM\HasLifecycleCallbacks
 */
class Credit
{
    use EntityIdTrait;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="creditManager")
     * @ORM\JoinColumn(nullable=true)
     */
    private User $manager;

    /**
     * @Assert\Choice(callback={CreditStatus::class, "values"})
     * @ORM\Column(type="CreditStatus", nullable=true)
     */
    private ?CreditStatus $creditStatus = null;

    /**
     * @ORM\OneToOne(targetEntity=CreditForm::class)
     */
    private CreditForm $creditForm;

    /**
     * @ORM\OneToOne(targetEntity=AllowedToDrive::class)
     */
    private AllowedToDrive $allowedToDrive;
}
