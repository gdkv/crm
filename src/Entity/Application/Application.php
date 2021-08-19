<?php

namespace App\Entity\Application;

use App\Entity\User;
use App\Entity\Dealer;
use App\Entity\EntityDateTrait;
use App\Entity\EntityDefaultTrait;
use App\Entity\EntityIdTrait;
use App\Entity\Application\Car;
use App\Model\Enum\ApplicationStatus;
use App\Model\Enum\Reason;
use App\Model\Enum\Source;
use App\Model\Enum\Type;
use App\Repository\ApplicationRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Instanceof_;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=ApplicationRepository::class)
 * @ORM\Table(name="`application`")
 * @ORM\HasLifecycleCallbacks
 */
class Application
{
    use EntityIdTrait;
    use EntityDefaultTrait;
    use EntityDateTrait;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $pushedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $actionAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $arrivedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Dealer::class)
     */
    private Dealer $dealer;

    /**
     * @Assert\Choice(callback={Type::class, "values"})
     * @ORM\Column(type="Type")
     */
    private Type $type;

    /**
     * @Assert\Choice(callback={ApplicationStatus::class, "values"})
     * @ORM\Column(type="ApplicationStatus")
     */
    private ApplicationStatus $status;

    /**
     * @ORM\OneToOne(targetEntity=Client::class)
     */
    private Client $client;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="applicationOperator")
     * @ORM\JoinColumn(nullable=true)
     */
    private User $operator;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="salesManager")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $manager;

    /**
     * @ORM\ManyToOne(targetEntity=Car::class)
     */
    private Car $car;

    /**
     * @ORM\ManyToMany(targetEntity=Car::class, inversedBy="applications")
     */
    private Collection $additionalCars;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isCredit;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isTradeIn;

    /**
     * @Assert\NotBlank()
     * @Assert\Collection(
     *      fields = { 
     *          "wheel" = @Assert\Type("bool"),
     *          "tires" = @Assert\Type("bool"),
     *          "towbar" = @Assert\Type("bool"),
     *          "alarm" = @Assert\Type("bool"),
     *          "thresholds" = @Assert\Type("bool"),
     *          "travelSet" = @Assert\Type("bool"),
     *          "petrolTank" = @Assert\Type("bool"),
     *          "registration" = @Assert\Type("bool"),
     *          "travel" = @Assert\Type("bool"),
     *          "color" = @Assert\Type("bool"),
     *          "insurance" = @Assert\Type("bool"),
     *          "anticorrosiveProtection" = @Assert\Type("bool"),
     *          "roofRails" = @Assert\Type("bool"),
     *          "yearWarranty" = @Assert\Type("bool"),
     *          "videoRecorder" = @Assert\Type("bool")
     *      },
     *      allowMissingFields = true
     * )
     * @ORM\Column(type="json")
     */
    private array $gift;
    
    /**
     * @Assert\Type("array"),
     * @Assert\All({
     *      @Assert\Collection(
     *           fields = { 
     *               "order" = {
     *                   @Assert\NotBlank(),
     *                   @Assert\Range(
     *                       min = 1,
     *                       max = 5
     *                   )
     *               }, 
     *               "status" = @Assert\Type("bool"),
     *               "date" = @Assert\DateTime 
     *           },
     *           allowMissingFields = false
     *      )
     * })
     * @ORM\Column(type="json", nullable=true)
     */
    private array $attempts;

    /**
     * @Assert\Choice(callback={Source::class, "values"})
     * @ORM\Column(type="Source")
     */
    private Source $source;

    /**
     * @Assert\Choice(callback={Reason::class, "values"})
     * @ORM\Column(type="Reason")
     */
    private Reason $reason;

    /**
     * @ORM\OneToOne(targetEntity=Credit::class)
     */
    private ?Credit $credit;

    /**
     * @ORM\ManyToMany(targetEntity=Comment::class, inversedBy="applications")
     */
    private Collection $comments;

    /**
     * @ORM\ManyToMany(targetEntity=Target::class, inversedBy="applications")
     */
    private Collection $targets;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isProcessed = false;

    public function __construct()
    {
        $this->additionalCars = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->targets = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'dealer' => $this->getDealer()->jsonSerialize(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
            'pushedAt' => $this->getPushedAt(),
            'actionAt' => $this->getActionAt(),
            'arrivedAt' => $this->getArrivedAt(),
            'status' => [
                $this->getStatus()->getValue(),
                $this->getStatus()->getReadable(),
            ],
            'type' => [
                $this->getType()->getValue(),
                $this->getType()->getReadable(),
            ],
            'client' => $this->getClient()->jsonSerialize(),
            'operator' => $this->getOperator()->jsonSerialize(),
            'manager' => ($this->getManager() instanceof User ? $this->getManager()->jsonSerialize() : null),
            'car' => $this->getCar()->jsonSerialize(),
            'additionalCars' => array_map(
                fn(Car $car) => $car->jsonSerialize(),
                $this->getAdditionalCars()->toArray()
            ),
            'isCredit' => $this->getIsCredit(),
            'isTradeIn' => $this->getIsTradeIn(),
            'gift' => $this->getGift(),
            'source' => [
                $this->getSource()->getValue(),
                $this->getSource()->getReadable(),
            ],
            'reason' => [
                $this->getReason()->getValue(),
                $this->getReason()->getReadable(),
            ],
            'attempts' => $this->getAttempts(),
            'credit' => $this->getCredit(),
            'comments' => $this->getComments(),
            'targets' => $this->getTargets(),
            'isProcessed' => $this->getIsProcessed(),
        ];
    }

    public function getPushedAt(): ?\DateTimeInterface
    {
        return $this->pushedAt;
    }

    public function setPushedAt(\DateTimeInterface $pushedAt): self
    {
        $this->pushedAt = $pushedAt;

        return $this;
    }

    public function getActionAt(): ?\DateTimeInterface
    {
        return $this->actionAt;
    }

    public function setActionAt(\DateTimeInterface $actionAt): self
    {
        $this->actionAt = $actionAt;

        return $this;
    }

    public function getArrivedAt(): ?\DateTimeInterface
    {
        return $this->arrivedAt;
    }

    public function setArrivedAt(\DateTimeInterface $arrivedAt): self
    {
        $this->arrivedAt = $arrivedAt;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIsCredit(): ?bool
    {
        return $this->isCredit;
    }

    public function setIsCredit(?bool $isCredit): self
    {
        $this->isCredit = $isCredit;

        return $this;
    }

    public function getIsTradeIn(): ?bool
    {
        return $this->isTradeIn;
    }

    public function setIsTradeIn(bool $isTradeIn): self
    {
        $this->isTradeIn = $isTradeIn;

        return $this;
    }

    public function getGift(): ?array
    {
        return $this->gift;
    }

    public function setGift(array $gift): self
    {
        $this->gift = $gift;

        return $this;
    }

    public function getAttempts(): ?array
    {
        return $this->attempts;
    }

    public function setAttempts(?array $attempts): self
    {
        $this->attempts = $attempts;

        return $this;
    }

    public function getIsProcessed(): ?bool
    {
        return $this->isProcessed;
    }

    public function setIsProcessed(bool $isProcessed): self
    {
        $this->isProcessed = $isProcessed;

        return $this;
    }

    public function getDealer(): ?Dealer
    {
        return $this->dealer;
    }

    public function setDealer(?Dealer $dealer): self
    {
        $this->dealer = $dealer;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getOperator(): ?User
    {
        return $this->operator;
    }

    public function setOperator(?User $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    /**
     * @return Collection|Car[]
     */
    public function getAdditionalCars(): Collection
    {
        return $this->additionalCars;
    }

    public function addAdditionalCar(Car $additionalCar): self
    {
        if (!$this->additionalCars->contains($additionalCar)) {
            $this->additionalCars[] = $additionalCar;
        }

        return $this;
    }

    public function removeAdditionalCar(Car $additionalCar): self
    {
        $this->additionalCars->removeElement($additionalCar);

        return $this;
    }

    public function getCredit(): ?Credit
    {
        return $this->credit;
    }

    public function setCredit(?Credit $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        $this->comments->removeElement($comment);

        return $this;
    }

    /**
     * @return Collection|Target[]
     */
    public function getTargets(): Collection
    {
        return $this->targets;
    }

    public function addTarget(Target $target): self
    {
        if (!$this->targets->contains($target)) {
            $this->targets[] = $target;
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        $this->targets->removeElement($target);

        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setReason($reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    
}
