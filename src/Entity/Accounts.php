<?php

namespace App\Entity;

use App\Entity\Users;
use App\Repository\AccountsRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\AccountType;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: AccountsRepository::class)]
class Accounts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $amount_btc = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'accounts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    #[ORM\Column(length: 255, type: Types::STRING, enumType: AccountType::class)]
    private ?AccountType $type = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmountBtc(): ?float
    {
        return $this->amount_btc;
    }

    public function setAmountBtc(float $amount_btc): static
    {
        $this->amount_btc = $amount_btc;

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

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }


    public function getType(): ?AccountType
    {
        return $this->type;
    }

    public function setType(?AccountType $type): self
    {
        $this->type = $type;
        return $this;
    }


}
