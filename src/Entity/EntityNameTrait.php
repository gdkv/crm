<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait EntityNameTrait {
    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

}