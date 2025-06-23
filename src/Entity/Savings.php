<?php

namespace App\Entity;

use App\Repository\SavingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SavingsRepository::class)]
class Savings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $amount_btc = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'savings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $user = null;

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

    public function getUser(): ?users
    {
        return $this->user;
    }

    public function setUser(?users $user): static
    {
        $this->user = $user;

        return $this;
    }
}
