<?php

namespace App\Entity\Application;

use App\Entity\EntityIdTrait;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    use EntityIdTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $brand;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $equipment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $transmission;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $engine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $drive;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $year;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $color;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $tradeInPrice;

     /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $tradeInOwnerPrice;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isUsed = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $additionalData;

    /**
     * @ORM\ManyToMany(targetEntity=Application::class, mappedBy="additionalCars")
     * @Ignore()
     */
    private Collection $applications;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'brand' =>$this->getBrand(),
            'model' =>$this->getModel(),
            'equipment' => $this->getEquipment(),
            'transmission' => $this->getTransmission(),
            'engine' => $this->getEngine(),
            'drive' => $this->getDrive(),
            'year' => $this->getYear(),
            'color' => $this->getColor(),
            'price' => $this->getPrice(),
            'tradeInPrice' => $this->getTradeInPrice(),
            'tradeInOwnerPrice' => $this->getTradeInOwnerPrice(),
            'isUsed' => $this->getIsUsed(),
            'additionalData' => $this->getAdditionalData(),
        ];
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getEquipment(): ?string
    {
        return $this->equipment;
    }

    public function setEquipment(?string $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getTransmission(): ?string
    {
        return $this->transmission;
    }

    public function setTransmission(?string $transmission): self
    {
        $this->transmission = $transmission;

        return $this;
    }

    public function getEngine(): ?string
    {
        return $this->engine;
    }

    public function setEngine(?string $engine): self
    {
        $this->engine = $engine;

        return $this;
    }

    public function getDrive(): ?string
    {
        return $this->drive;
    }

    public function setDrive(?string $drive): self
    {
        $this->drive = $drive;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTradeInPrice(): ?int
    {
        return $this->tradeInPrice;
    }

    public function setTradeInPrice(?int $tradeInPrice): self
    {
        $this->tradeInPrice = $tradeInPrice;

        return $this;
    }

    public function getTradeInOwnerPrice(): ?int
    {
        return $this->tradeInOwnerPrice;
    }

    public function setTradeInOwnerPrice(?int $tradeInOwnerPrice): self
    {
        $this->tradeInOwnerPrice = $tradeInOwnerPrice;

        return $this;
    }

    public function getIsUsed(): ?bool
    {
        return $this->isUsed;
    }

    public function setIsUsed(?bool $isUsed): self
    {
        $this->isUsed = $isUsed;

        return $this;
    }

    public function getAdditionalData(): ?string
    {
        return $this->additionalData;
    }

    public function setAdditionalData(?string $additionalData): self
    {
        $this->additionalData = $additionalData;

        return $this;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->addAdditionalCar($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            $application->removeAdditionalCar($this);
        }

        return $this;
    }
}
