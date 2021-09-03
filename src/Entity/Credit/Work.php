<?php

namespace App\Entity\Credit;

use App\Entity\EntityIdTrait;
use App\Repository\RegionRepository;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=Work::class)
 */
class Work
{
    use EntityIdTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $organisation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $organisationLtdAdress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $organizationFactAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $managerName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $workPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $workAccountantPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $organizationTaxNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $organizationScope;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $position;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $workExperience = null;

    /**
     * @Assert\GreaterThan(
     *     value = 1900
     * )
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $totalWorkExperience;

    /**
     * @Assert\PositiveOrZero
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $income;

    /**
     * @Assert\PositiveOrZero
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $additionalIncome;

    /**
     * @Assert\PositiveOrZero
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $totalIncome;

}
