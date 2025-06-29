<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['username'], message: 'This username is already taken')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    private ?string $plainPassword = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $username = null;


    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Accounts>
     */
    #[ORM\OneToMany(targetEntity: Accounts::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $accounts;

    /**
     * @var Collection<int, Transactions>
     */
    #[ORM\OneToMany(targetEntity: Transactions::class, mappedBy: 'from_user', orphanRemoval: true)]
    private Collection $transaction_from;

    /**
     * @var Collection<int, Transactions>
     */
    #[ORM\OneToMany(targetEntity: Transactions::class, mappedBy: 'to_user', orphanRemoval: true)]
    private Collection $transaction_to;

    //#[ORM\Column]
    //private array $Roles = [];

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private bool $isVerified = false;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
        $this->transaction_from = new ArrayCollection();
        $this->transaction_to = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
        $this->roles = ['ROLE_USER']; // default role
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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
     * @return Collection<int, Accounts>
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(Accounts $account): static
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts->add($account);
            $account->setUser($this);
        }

        return $this;
    }

    public function removeAccount(Accounts $account): static
    {
        if ($this->accounts->removeElement($account)) {
            // set the owning side to null (unless already changed)
            if ($account->getUser() === $this) {
                $account->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transactions>
     */
    public function getTransactionsFrom(): Collection
    {
        return $this->transaction_from;
    }

    public function addTransactionsFrom(Transactions $transactionFrom): static
    {
        if (!$this->transaction_from->contains($transactionFrom)) {
            $this->transaction_from->add($transactionFrom);
            $transactionFrom->setFromUser($this);
        }

        return $this;
    }

    public function removeTransactionsFrom(Transactions $transactionFrom): static
    {
        if ($this->transaction_from->removeElement($transactionFrom)) {
            // set the owning side to null (unless already changed)
            if ($transactionFrom->getFromUser() === $this) {
                $transactionFrom->setFromUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tips>
     */
    public function getTransactionsTo(): Collection
    {
        return $this->transaction_to;
    }

    public function addTransactionsTo(Transactions $transactionTo): static
    {
        if (!$this->transaction_to->contains($transactionTo)) {
            $this->transaction_to->add($transactionTo);
            $transactionTo->setToUser($this);
        }

        return $this;
    }

    public function removeTransactionsTo(Transactions $transactionTo): static
    {
        if ($this->transaction_to->removeElement($transactionTo)) {
            // set the owning side to null (unless already changed)
            if ($transactionTo->getToUser() === $this) {
                $transactionTo->setToUser(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function __toString(): string
    {
        return $this->username ?? (string) $this->getId();
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

}
