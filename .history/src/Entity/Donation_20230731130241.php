<?php

namespace App\Entity;

use App\Repository\DonationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DonationRepository::class)
 */
class Donation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $donationDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="donations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $donor;

    /**
     * @ORM\ManyToOne(targetEntity=CollectionCenter::class, inversedBy="donations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $collectionCenter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDonationDate(): ?\DateTimeInterface
    {
        return $this->donationDate;
    }

    public function setDonationDate(\DateTimeInterface $donationDate): self
    {
        $this->donationDate = $donationDate;
        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getDonor(): ?User
    {
        return $this->donor;
    }

    public function setDonor(?User $donor): self
    {
        $this->donor = $donor;
        return $this;
    }

    public function getCollectionCenter(): ?CollectionCenter
    {
        return $this->collectionCenter;
    }

    public function setCollectionCenter(?CollectionCenter $collectionCenter): self
    {
        $this->collectionCenter = $collectionCenter;
        return $this;
    }
}
