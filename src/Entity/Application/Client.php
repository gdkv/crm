<?php

namespace App\Entity\Application;

use App\Entity\EntityIdTrait;
use App\Entity\EntityNameTrait;
use App\Entity\Region;
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
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $surname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $patronymic;

    /**
     * @Assert\Type("array"),
     * @Assert\All({
     *      @Assert\Type("string")
     * })
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private ?array $phone = [];

    /**
     * @Assert\Choice(callback={Gender::class, "values"})
     * @ORM\Column(type="Gender", nullable=true)
     */
    private ?Gender $gender;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $dateOfBirth = null;

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
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Region $region;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(?string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    public function getPhone(): ?array
    {
        return $this->phone;
    }

    public function setPhone(array $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getAdditional(): ?array
    {
        return $this->additional;
    }

    public function setAdditional(?array $additional): self
    {
        $this->additional = $additional;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }
}
