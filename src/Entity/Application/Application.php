<?php

namespace App\Entity\Application;

use App\Entity\User;
use App\Entity\Dealer;
use App\Entity\Credit\Credit;
use App\Entity\Application\Car;
use App\Entity\EntityDateTrait;
use App\Entity\EntityDefaultTrait;
use App\Entity\EntityIdTrait;
use App\Model\Enum\ApplicationStatus;
use App\Model\Enum\Reason;
use App\Model\Enum\Source;
use App\Model\Enum\Type;
use App\Repository\ApplicationRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;
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
    private ?DateTimeInterface $arrivedAt = null;

    /**
     * @ORM\ManyToOne(targetEntity=Dealer::class)
     * @Ignore()
     */
    private Dealer $dealer;

    /**
     * @Assert\Choice(callback={Type::class, "values"})
     * @ORM\Column(type="Type")
     */
    private Type $type;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private Status $status;

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
    private ?User $manager = null;

    /**
     * @Assert\All({
     *     @Assert\Type(Car::class)
     * })
     * @ORM\ManyToMany(targetEntity=Car::class, inversedBy="applications")
     */
    private ?iterable $car = [];

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isCredit = null;

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
     * @ORM\Column(type="Source", nullable=true)
     */
    private ?Source $source = null;

    /**
     * @Assert\Choice(callback={Reason::class, "values"})
     * @ORM\Column(type="Reason", nullable=true)
     */
    private ?Reason $reason = null;

    /**
     * @ORM\OneToOne(targetEntity=Credit::class)
     * @Ignore()
     */
    private ?Credit $credit = null;

    /**
     * @Assert\All({
     *     @Assert\Type(Comment::class)
     * })
     * @ORM\ManyToMany(targetEntity=Comment::class)
     * Ignore()
     */
    private ?iterable $comment = [];

    /**
     * @Assert\All({
     *     @Assert\Type(Target::class)
     * })
     * @ORM\ManyToMany(targetEntity=Target::class)
     * Ignore()
     */
    private ?iterable $targets = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isProcessed = false;

    public function __construct(
        DateTimeInterface $actionAt,
        ?DateTimeInterface $arrivedAt,
        ?Dealer $dealer,
        ?Client $client,
        ?User $operator,
        ?User $manager,
        ?array $cars,
        Type $type,
        Status $status,
        ?bool $isCredit,
        bool $isTradeIn,
        ?array $attempts,
        array $gift,
        ?Source $source,
        ?Reason $reason,
        array $comments,
        bool $isProcessed
    ) {
        $this->pushedAt = new DateTime('now');
        $this->update($actionAt, $arrivedAt, $dealer, $client, $operator, $manager, $cars, $type, $status, $isCredit, $isTradeIn, $attempts, $gift, $source, $reason, $comments, $isProcessed);
    }

    public function update(
        DateTimeInterface $actionAt,
        ?DateTimeInterface $arrivedAt,
        ?Dealer $dealer,
        ?Client $client,
        ?User $operator,
        ?User $manager,
        array $cars,
        Type $type,
        Status $status,
        ?bool $isCredit,
        bool $isTradeIn,
        ?array $attempts,
        array $gift,
        ?Source $source,
        ?Reason $reason,
        array $comments,
        bool $isProcessed
    ) {
        $this->actionAt = $actionAt;
        $this->arrivedAt = $arrivedAt;
        $this->dealer = $dealer;
        $this->client = $client;
        $this->operator = $operator;
        $this->manager = $manager;
        $this->type = $type;
        $this->status = $status;
        $this->isCredit = $isCredit;
        $this->isTradeIn = $isTradeIn;
        $this->attempts = $attempts;
        $this->gift = $gift;
        $this->source = $source;
        $this->reason = $reason;
        $this->isProcessed = $isProcessed;
        $this->car = $cars;
        $this->comment = $comments;
    }

    public function getPushedAt(): ?DateTimeInterface
    {
        return $this->pushedAt;
    }

    public function getActionAt(): ?DateTimeInterface
    {
        return $this->actionAt;
    }

    public function getArrivedAt(): ?DateTimeInterface
    {
        return $this->arrivedAt;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getIsCredit(): ?bool
    {
        return $this->isCredit;
    }

    public function getIsTradeIn(): ?bool
    {
        return $this->isTradeIn;
    }

    public function getGift(): ?array
    {
        return $this->gift;
    }

    public function getAttempts(): ?array
    {
        return $this->attempts;
    }

    public function getIsProcessed(): ?bool
    {
        return $this->isProcessed;
    }

    public function getDealer(): ?Dealer
    {
        return $this->dealer;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function getOperator(): ?User
    {
        return $this->operator;
    }

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function getCar(): ?iterable
    {
        return $this->car;
    }

    public function getCredit(): ?Credit
    {
        return $this->credit;
    }

    public function getComment(): ?iterable
    {
        return $this->comment;
    }

    public function getTargets(): ?iterable
    {
        return $this->targets;
    }

    public function getSource(): ?Source
    {
        return $this->source;
    }

    public function getReason(): ?Reason
    {
        return $this->reason;
    }

}
