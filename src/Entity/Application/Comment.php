<?php

namespace App\Entity\Application;

use App\Entity\EntityIdTrait;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 */
class Comment
{
    use EntityIdTrait;

    /**
     * @ORM\ManyToMany(targetEntity=Application::class, mappedBy="comments")
     */
    private Collection $applications;
}
