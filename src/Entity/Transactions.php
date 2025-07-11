<?php

namespace App\Entity;

use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionsRepository::class)]
class Transactions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $amount_btc = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'transaction_from')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $from_user = null;

    #[ORM\ManyToOne(inversedBy: 'transaction_to')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $to_user = null;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

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

    public function getFromUser(): ?Users
    {
        return $this->from_user;
    }

    public function setFromUser(?Users $from_user): static
    {
        $this->from_user = $from_user;

        return $this;
    }

    public function getToUser(): ?Users
    {
        return $this->to_user;
    }

    public function setToUser(?Users $to_user): static
    {
        $this->to_user = $to_user;

        return $this;
    }
}
