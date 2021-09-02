<?php

namespace App\Entity\Credit;

use App\Entity\EntityDateTrait;
use App\Entity\EntityIdTrait;
use App\Entity\EntityNameTrait;
use App\Repository\CreditFormRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=CreditFormRepository::class)
 * @ORM\Table(name="`credit_form`")
 * @ORM\HasLifecycleCallbacks
 */
class CreditForm
{
    use EntityIdTrait;
    use EntityDateTrait;
    use EntityNameTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $maidenName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $planDate = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $dateOfBirth = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $placeOfBirth;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private ?array $phoneNumber = [];

    /**
     * @ORM\OneToOne(targetEntity=Document::class)
     */
    private Document $passport;

}
