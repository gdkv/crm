<?php

namespace App\Entity\Application;

use App\Entity\EntityDateTrait;
use App\Entity\EntityIdTrait;
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


    public function getText(): string
    {
        return $this->text;
    }


    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
