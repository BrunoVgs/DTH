// src/Entity/Donation.php

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

    // Getters and setters for the properties

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDonorFirstName(): ?string
    {
        return $this->donorFirstName;
    }

    public function setDonorFirstName(string $donorFirstName): self
    {
        $this->donorFirstName = $donorFirstName;
        return $this;
    }

    public function getDonorLastName(): ?string
    {
        return $this->donorLastName;
    }

    public function setDonorLastName(string $donorLastName): self
    {
        $this->donorLastName = $donorLastName;
        return $this;
    }

    public function getCollectionCenter(): ?string
    {
        return $this->collectionCenter;
    }

    public function setCollectionCenter(string $collectionCenter): self
    {
        $this->collectionCenter = $collectionCenter;
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
}
