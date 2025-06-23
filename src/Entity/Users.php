<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Users implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    private ?string $plainPassword = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;


    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Savings>
     */
    #[ORM\OneToMany(targetEntity: Savings::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $savings;

    /**
     * @var Collection<int, Tips>
     */
    #[ORM\OneToMany(targetEntity: Tips::class, mappedBy: 'from_user', orphanRemoval: true)]
    private Collection $tips_from;

    /**
     * @var Collection<int, Tips>
     */
    #[ORM\OneToMany(targetEntity: Tips::class, mappedBy: 'to_user', orphanRemoval: true)]
    private Collection $tips_to;

    //#[ORM\Column]
    //private array $Roles = [];

    #[ORM\Column]
    private array $roles = [];

    public function __construct()
    {
        $this->savings = new ArrayCollection();
        $this->tips_from = new ArrayCollection();
        $this->tips_to = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Savings>
     */
    public function getSavings(): Collection
    {
        return $this->savings;
    }

    public function addSaving(Savings $saving): static
    {
        if (!$this->savings->contains($saving)) {
            $this->savings->add($saving);
            $saving->setUser($this);
        }

        return $this;
    }

    public function removeSaving(Savings $saving): static
    {
        if ($this->savings->removeElement($saving)) {
            // set the owning side to null (unless already changed)
            if ($saving->getUser() === $this) {
                $saving->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tips>
     */
    public function getTipsFrom(): Collection
    {
        return $this->tips_from;
    }

    public function addTipsFrom(Tips $tipsFrom): static
    {
        if (!$this->tips_from->contains($tipsFrom)) {
            $this->tips_from->add($tipsFrom);
            $tipsFrom->setFromUser($this);
        }

        return $this;
    }

    public function removeTipsFrom(Tips $tipsFrom): static
    {
        if ($this->tips_from->removeElement($tipsFrom)) {
            // set the owning side to null (unless already changed)
            if ($tipsFrom->getFromUser() === $this) {
                $tipsFrom->setFromUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tips>
     */
    public function getTipsTo(): Collection
    {
        return $this->tips_to;
    }

    public function addTipsTo(Tips $tipsTo): static
    {
        if (!$this->tips_to->contains($tipsTo)) {
            $this->tips_to->add($tipsTo);
            $tipsTo->setToUser($this);
        }

        return $this;
    }

    public function removeTipsTo(Tips $tipsTo): static
    {
        if ($this->tips_to->removeElement($tipsTo)) {
            // set the owning side to null (unless already changed)
            if ($tipsTo->getToUser() === $this) {
                $tipsTo->setToUser(null);
            }
        }

        return $this;
    }

    public function getPlainPassword(): ?string {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self {
        $this->plainPassword = $plainPassword;

        return $this;
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

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
}
