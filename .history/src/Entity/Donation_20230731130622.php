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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="donations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $donor;

    /**
     * @ORM\ManyToOne(targetEntity=CollectionCenter::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $collectionCenter;

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
