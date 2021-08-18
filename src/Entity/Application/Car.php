<?php

namespace App\Entity\Application;

use App\Entity\EntityIdTrait;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    use EntityIdTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $brand;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $equipment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $transmission;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $engine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $drive;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $year;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $color;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $tradeInPrice;

     /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $tradeInOwnerPrice;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isUsed = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private string $additionalData;

    /**
     * @ORM\ManyToMany(targetEntity=Application::class, mappedBy="additionalCars")
     */
    private Collection $applications;
}
