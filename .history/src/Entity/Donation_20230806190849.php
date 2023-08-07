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
     * @ORM\Column(type="string", length=255)
     */
    private $donorFirstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $donorLastName;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $collectionCenter;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
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
    
    public function getCollectionCenterName(): ?string
    {
        return $this->collectionCenter;
    }

    public function setFirstname(string $collectionCenter): self
    {
        $this->collectionCenter = $collectionCenter;
        return $this;
    }

}
