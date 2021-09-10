<?php

namespace App\Entity\Credit;

use App\Entity\EntityDateTrait;
use App\Entity\EntityIdTrait;
use App\Entity\EntityNameTrait;
use App\Entity\Credit\Document;
use App\Model\Enum\DriverCategory;
use App\Entity\Region;
use App\Model\Enum\FamilyStatus;
use App\Repository\CreditFormRepository;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=CreditFormRepository::class)
 * @ORM\Table(name="`credit_form`")
 * @ORM\HasLifecycleCallbacks
 */
class CreditForm
{
    use EntityIdTrait;
    use EntityDateTrait;
    use EntityNameTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $maidenName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $planDate = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $dateOfBirth = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $placeOfBirth;

    /**
     * @Assert\Type("array"),
     * @Assert\All({
     *      @Assert\Type("string")
     * })
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private ?array $phone = [];

    /**
     * @ORM\OneToOne(targetEntity=Document::class)
     */
    private Document $passport;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="creditForm")
     */
    private ?ArrayCollection $previousPassports;

    /**
     * @ORM\OneToOne(targetEntity=Document::class)
     */
    private ?Document $driverLicense;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $driverExperience = null;

    /**
     * @Assert\Choice(callback={DriverCategory::class, "values"})
     * @ORM\Column(type="DriverCategory", nullable=true)
     */
    private ?DriverCategory $driverCategory = null;

    /**
     * @Assert\Type("int")
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $personInsuranceNumber;

    /**
     * @ORM\OneToOne(targetEntity=Document::class)
     */
    private ?Document $internationalPassport;

    /**
     * @ORM\OneToOne(targetEntity=Document::class)
     */
    private ?Document $militaryId;

    /**
     * @Assert\Type("array"),
     * @Assert\All({
     *      @Assert\Collection(
     *           fields = { 
     *               "type" = @Assert\Choice({"actual", "registration"}),
     *               "address" = @Assert\Type("string"), 
     *               "region" = @Assert\Type(Region::class),
     *               "date" = @Assert\DateTime,
     *               "phoneNumber" = @Assert\Type("string"), 
     *               "isOwner" = @Assert\Type("bool")
     *           },
     *           allowMissingFields = false
     *      )
     * })
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $placeOfResidence;

    /**
     * @Assert\Collection(
     *      fields = { 
     *          "secondary" = @Assert\Type("bool"),
     *          "higher" = @Assert\Type("bool")
     *      },
     *      allowMissingFields = true
     * )
     * @ORM\Column(type="json")
     */
    private ?array $education;

    /**
     * @ORM\OneToOne(targetEntity=Work::class)
     */
    private ?Work $work;

    /**
     * @Assert\Choice(callback={FamilyStatus::class, "values"})
     * @ORM\Column(type="FamilyStatus", nullable=true)
     */
    private ?FamilyStatus $familyStatus = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $spouseName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $spouseDateOfBirth = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $spousePlaceOfBirth;

    /**
     * @Assert\Type("array"),
     * @Assert\All({
     *      @Assert\Type("string")
     * })
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private ?array $spousePhoneNumber;

    /**
     * @ORM\OneToOne(targetEntity=Work::class)
     */
    private ?Work $spouseWork;

    /**
     * @Assert\Type("array"),
     * @Assert\All({
     *      @Assert\Collection(
     *           fields = { 
     *               "name" = @Assert\Type("string"), 
     *               "dateOfBirth" = @Assert\DateTime
     *           },
     *           allowMissingFields = false
     *      )
     * })
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $children;

    /**
     * @Assert\Type("array"),
     * @Assert\All({
     *      @Assert\Collection(
     *           fields = { 
     *               "bank" = @Assert\Type("string"), 
     *               "sum" = {
     *                  @Assert\Type("int"),
     *                  @Assert\PositiveOrZero
     *               },
     *               "monthlyPayment" = {
     *                  @Assert\Type("int"),
     *                  @Assert\PositiveOrZero
     *               }
     *           },
     *           allowMissingFields = false
     *      )
     * })
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $activeCredits;

    /**
     * @Assert\PositiveOrZero
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $firstFee;

    /**
     * @Assert\PositiveOrZero
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $creditMonth;

    /**
     * @Assert\PositiveOrZero
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $monthlyPayment;

    /**
     * @Assert\PositiveOrZero
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $wishMonthlyPayment;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $car;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $equipment;

    /**
     * @Assert\PositiveOrZero
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $carPrice;
    
    /**
     * @Assert\Type("array"),
     * @Assert\All({
     *      @Assert\Collection(
     *           fields = { 
     *               "relation" = @Assert\Type("string"), 
     *               "name" = @Assert\Type("string"), 
     *               "dateOfBirth" = @Assert\DateTime,
     *               "placeOfResidence" = @Assert\Type("string"), 
     *               "phone" = @Assert\Type("array")
     *           },
     *           allowMissingFields = false
     *      )
     * })
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $contactPerson;

    public function __construct()
    {
        $this->previousPassports = new ArrayCollection();
    }
}
