<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Model\Enum\Role;
use App\Model\Enum\Status;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\All({
     *     @Assert\NotBlank,
     *     @Assert\Type("string"),
     *     @Assert\Choice(callback={Role::class, "values"})
     * })
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Assert\Choice(callback={Status::class, "values"})
     * @ORM\Column(type="Status")
     */
    private Status $status;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Dealer::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
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

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUserIdentifier(),
            'roles' => $this->getRoles(),
            'aliasName' => $this->getAliasName(),
            'name' => $this->getName(),
            'status' => $this->getStatus(),
            'dealer' => $this->getDealer()->jsonSerialize(),
            'mangoId' => $this->getMangoId(),
            'smsText' => $this->getSmsText(),
            'isWorking' => $this->getIsWorking(),
            'isRemote' => $this->getIsRemote(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
        ];
    }

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
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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
}
