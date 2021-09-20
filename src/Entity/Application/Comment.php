<?php

namespace App\Entity\Application;

use App\Entity\EntityDateTrait;
use App\Entity\EntityIdTrait;
use App\Entity\User;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 * @ORM\Table(name="`comment`")
 * @ORM\HasLifecycleCallbacks
 */
class Comment
{
    use EntityIdTrait;
    use EntityDateTrait;

    /**
     * @ORM\Column(type="text")
     */
    private string $text;

    /**
     * @ORM\ManyToMany(targetEntity=Application::class, mappedBy="comments")
     * @Ignore()
     */
    private Collection $applications;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private User $operator;

    public function __construct(string $text, User $operator)
    {
        $this->text = $text;
        $this->operator = $operator;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getOperator(): User
    {
        return $this->operator;
    }

}
