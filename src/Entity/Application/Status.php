<?php

namespace App\Entity\Application;

use App\Entity\EntityDateTrait;
use App\Entity\EntityIdTrait;
use App\Entity\EntityNameTrait;
use App\Model\Enum\ApplicationStatus;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 * @ORM\Table(name="`status`")
 * @ORM\HasLifecycleCallbacks
 */
class Status
{
    use EntityIdTrait;
    use EntityNameTrait;
    
    /**
     * @Assert\Choice(callback={ApplicationStatus::class, "values"})
     * @ORM\Column(type="ApplicationStatus")
     */
    private ApplicationStatus $status;

    /**
     * @Assert\Choice({"white", "grey", "yellow", "blue", "red"})
     * @ORM\Column(type="string", length=255)
     */
    private string $color;

    public function __construct(
        string $name,
        ApplicationStatus $status,
        string $color
    ){
        $this->update($name, $status, $color);
    }

    public function update(
        string $name,
        ApplicationStatus $status,
        string $color
    ){
        $this->name = $name;
        $this->status = $status;
        $this->color = $color;
    }

    public function getStatus(): ?ApplicationStatus
    {
        return $this->status;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

}
