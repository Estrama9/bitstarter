<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Savings>
     */
    #[ORM\OneToMany(targetEntity: Savings::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $savings;

    public function __construct()
    {
        $this->savings = new ArrayCollection();
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
}
