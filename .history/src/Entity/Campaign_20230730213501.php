<?php

// src/Entity/Campaign.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Campaign
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    // Add other properties, getters, and setters as needed.

    /**
     * @ORM\ManyToOne(targetEntity="CollectionCenter", inversedBy="campaigns")
     * @ORM\JoinColumn(name="collection_center_id", referencedColumnName="id")
     */
    private $collectionCenter;

    // Add the getter and setter for the $collectionCenter property.
}
