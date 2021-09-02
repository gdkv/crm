<?php

namespace App\Entity\Credit;

use App\Entity\EntityIdTrait;
use App\Repository\AllowedToDriveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AllowedToDriveRepository::class)
 * @ORM\Table(name="`allowed_to_drive`")
 * @ORM\HasLifecycleCallbacks
 */
class AllowedToDrive
{
    use EntityIdTrait;
    

}