<?php

namespace App\Entity;

use App\Repository\TransactionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionsRepository::class)]
class Transactions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateT = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column]
    private ?int $Id = null;

    #[ORM\Column]
    private ?int $IDmarket = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateT(): ?\DateTimeInterface
    {
        return $this->dateT;
    }

    public function setDateT(\DateTimeInterface $dateT): static
    {
        $this->dateT = $dateT;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function setId(int $Id): static
    {
        $this->Id = $Id;

        return $this;
    }

    public function getIDmarket(): ?int
    {
        return $this->IDmarket;
    }

    public function setIDmarket(int $IDmarket): static
    {
        $this->IDmarket = $IDmarket;

        return $this;
    }
}
