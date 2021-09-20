<?php

namespace App\Model\DTO;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class CommentDTO
{
    public function __construct(
        private string $text,
        private User $operator,
    ){}


    public function getText(): string
    {
        return $this->text;
    }

    public function getOperator(): User
    {
        return $this->operator;
    }
}