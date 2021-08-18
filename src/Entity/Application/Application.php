<?php

namespace App\Entity\Application;

use App\Entity\User;
use App\Entity\Dealer;
use App\Entity\EntityDateTrait;
use App\Entity\EntityDefaultTrait;
use App\Entity\EntityIdTrait;
use App\Entity\Application\Car;
use App\Model\Enum\ApplicationStatus;
use App\Repository\ApplicationRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $arrivedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Dealer::class)
     */
    private Dealer $dealer;

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
    private User $manager;

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
    private bool $isCredit;

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
     *               "status" = @Assert\Choice({"success", "fail"}),
     *               "date" = @Assert\DateTime 
     *           },
     *           allowMissingFields = false
     *      )
     * })
     * @ORM\Column(type="json", nullable=true)
     */
    private array $attempts;

    /**
     * @ORM\OneToOne(targetEntity=Credit::class)
     */
    private Credit $credit;

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
}
