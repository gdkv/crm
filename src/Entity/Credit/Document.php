<?php

namespace App\Entity\Credit;

use App\Entity\EntityIdTrait;
use App\Entity\Credit\CreditForm;
use App\Repository\DocumentRepository;
use Symfony\Component\Serializer\Annotation\Ignore;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 * @ORM\Table(name="`document`")
 * @ORM\HasLifecycleCallbacks
 */
class Document
{
    use EntityIdTrait;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $series = "";

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $number = "";

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $issuedBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $issuedAt = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity=CreditForm::class, inversedBy="previousPassports")
     * @Ignore()
     */
    private $creditForm;

    public function getSeries(): ?string
    {
        return $this->series;
    }

    public function setSeries(?string $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getIssuedBy(): ?string
    {
        return $this->issuedBy;
    }

    public function setIssuedBy(?string $issuedBy): self
    {
        $this->issuedBy = $issuedBy;

        return $this;
    }

    public function getIssuedAt(): ?\DateTimeInterface
    {
        return $this->issuedAt;
    }

    public function setIssuedAt(?\DateTimeInterface $issuedAt): self
    {
        $this->issuedAt = $issuedAt;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCreditForm(): ?CreditForm
    {
        return $this->creditForm;
    }

    public function setCreditForm(?CreditForm $creditForm): self
    {
        $this->creditForm = $creditForm;

        return $this;
    }
}