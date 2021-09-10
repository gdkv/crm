<?php

namespace App\Entity;

use App\Entity\Credit\Credit;
use App\Repository\UserRepository;
use App\Model\Enum\Role;
use App\Model\Enum\Status;
use App\Entity\Application\Application;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use EntityIdTrait;
    use EntityNameTrait;
    use EntityDefaultTrait;
    use EntityDateTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $aliasName;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @Assert\Choice(callback={Role::class, "values"})
     * @ORM\Column(type="Role", nullable=true)
     */
    private Role $role;

    /**
     * @Assert\Choice(callback={Status::class, "values"})
     * @ORM\Column(type="Status")
     */
    private Status $status;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Ignore()
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Dealer::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Ignore()
     */
    private $dealer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mangoId;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $smsText;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isWorking;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRemote;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $expiresAt = null;
    
    /**
     * @ORM\OneToMany(targetEntity=Application::class, mappedBy="operator", orphanRemoval=true)
     * @Ignore()
     */
    private $applicationOperator;

    /**
     * @ORM\OneToMany(targetEntity=Application::class, mappedBy="manager", orphanRemoval=true)
     * @Ignore()
     */
    private $salesManager;

    /**
     * @ORM\OneToMany(targetEntity=Credit::class, mappedBy="manager", orphanRemoval=true)
     * @Ignore()
     */
    private $creditManager;

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     * @see UserInterface
     * @Ignore()
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @Ignore()
     */
    public function getRoles(): array
    {
        $roles = [];

        $roles[] = $this->role->getValue();
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return $roles;
    }

    public function getRole(): string
    {
        return $this->role->getReadable();
    }

    public function setRoles(Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     * @Ignore()
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getMangoId(): ?int
    {
        return $this->mangoId;
    }

    public function setMangoId(?int $mangoId): self
    {
        $this->mangoId = $mangoId;

        return $this;
    }

    public function getSmsText(): ?string
    {
        return $this->smsText;
    }

    public function setSmsText(?string $smsText): self
    {
        $this->smsText = $smsText;

        return $this;
    }

    public function getIsWorking(): ?bool
    {
        return $this->isWorking;
    }

    public function setIsWorking(bool $isWorking): self
    {
        $this->isWorking = $isWorking;

        return $this;
    }

    public function getIsRemote(): ?bool
    {
        return $this->isRemote;
    }

    public function setIsRemote(bool $isRemote): self
    {
        $this->isRemote = $isRemote;

        return $this;
    }

    public function getAliasName(): ?string
    {
        return $this->aliasName;
    }

    public function setAliasName(string $aliasName): self
    {
        $this->aliasName = $aliasName;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getExpiresAt(): ?DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
