<?php

namespace App\Entity\Application;

use App\Entity\EntityIdTrait;
use App\Repository\TargetRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TargetRepository::class)
 */
class Target
{
    use EntityIdTrait;

    /**
     * @ORM\ManyToMany(targetEntity=Application::class, mappedBy="targets")
     */
    private Collection $applications;
}
