<?php

namespace App\Entity\Application;

use App\Entity\EntityIdTrait;
use App\Entity\EntityNameTrait;
use App\Model\Enum\Gender;
use App\Repository\ClientRepository;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    use EntityIdTrait;
    use EntityNameTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $surname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $patronymic;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $phone;

    /**
     * @Assert\Choice(callback={ApplicationStatus::class, "values"})
     * @ORM\Column(type="ApplicationStatus")
     */
    private Gender $gender;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $dateOfBirth;

    /**
     * @Assert\Type("array"),
     * @Assert\All({
     *  @Assert\Collection(
     *      fields = { 
     *          "name" = @Assert\Type("string"), 
     *          "phone" = @Assert\Type("string") 
     *      },
     *      allowMissingFields = false
     *  )
     * })
     * @ORM\Column(type="json", nullable=true)
     */
    private array $additional;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $region;
}
