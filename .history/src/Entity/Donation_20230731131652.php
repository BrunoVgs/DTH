<?php
// src/Entity/Donation.php

namespace App\Entity;

use App\Repository\DonationRepository;
use App\Entity\CollectionCenter;
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="donations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $donor;

    /**
     * @ORM\ManyToOne(targetEntity=CollectionCenter::class)
     * @ORM\JoinColumn(name="collection_center_id", referencedColumnName="id", nullable=false)
     */
    private $collectionCenter;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $amount;

    // Other properties, getters, setters, and any additional logic for Donation entity

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;
        return $this;
    }   
    public function getCollectionCenterName(): ?string
    {
        return $this->collectionCenter->getName();
    }


}
