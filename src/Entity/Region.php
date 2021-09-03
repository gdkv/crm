<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use App\Entity\Application\Client;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=RegionRepository::class)
 */
class Region
{
    use EntityNameTrait;
    use EntityIdTrait;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="region", orphanRemoval=true)
     * @Ignore()
     */
    private $clients;
}
