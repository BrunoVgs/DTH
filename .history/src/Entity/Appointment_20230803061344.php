<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 */
class Appointment
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
    private $appointmentDateTime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bloodGroup;

    /**
     * @ORM\Column(type="boolean")
     */
    private $medication;

    /**
     * @ORM\Column(type="boolean")
     */
    private $consent;

     /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=CollectionCenter::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $collectionCenter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppointmentDateTime(): ?\DateTimeInterface
    {
        return $this->appointmentDateTime;
    }

    public function setAppointmentDateTime(\DateTimeInterface $appointmentDateTime): self
    {
        $this->appointmentDateTime = $appointmentDateTime;

        return $this;
    }

    public function getBloodGroup(): ?string
    {
        return $this->bloodGroup;
    }

    public function setBloodGroup(string $bloodGroup): self
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    public function isMedication(): ?bool
    {
        return $this->medication;
    }

    public function setMedication(bool $medication): self
    {
        $this->medication = $medication;

        return $this;
    }

    public function hasConsent(): ?bool
    {
        return $this->consent;
    }

    public function setConsent(bool $consent): self
    {
        $this->consent = $consent;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
