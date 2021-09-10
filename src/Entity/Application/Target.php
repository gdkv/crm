<?php

namespace App\Entity\Application;

use App\Entity\EntityIdTrait;
use App\Repository\TargetRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=TargetRepository::class)
 */
class Target
{
    use EntityIdTrait;

    /**
     * @Ignore()
     * @ORM\ManyToMany(targetEntity=Application::class, mappedBy="targets")
     */
    private Collection $applications;
}
