<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=Donation::class, mappedBy="donor")
     */
    private $donations;

    /**
     * @ORM\OneToOne(targetEntity=Volunteer::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $volunteer;

    public function __construct()
    {
        $this->donations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        // La méthode getRoles doit retourner un tableau de rôles.
        // Nous ajoutons le rôle 'ROLE_USER' par défaut, mais vous pouvez modifier cela selon vos besoins.
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getDonations(): Collection
    {
        return $this->donations;
    }

    public function addDonation(Donation $donation): self
    {
        if (!$this->donations->contains($donation)) {
            $this->donations[] = $donation;
            $donation->setDonor($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): self
    {
        if ($this->donations->removeElement($donation)) {
            // set the owning side to null (unless already changed)
            if ($donation->getDonor() === $this) {
                $donation->setDonor(null);
            }
        }

        return $this;
    }

    public function getVolunteer(): ?Volunteer
    {
        return $this->volunteer;
    }

    public function setVolunteer(?Volunteer $volunteer): self
    {
        $this->volunteer = $volunteer;

        // set (or unset) the owning side of the relation if necessary
        $newUser = null === $volunteer ? null : $this;
        if ($volunteer->getUser() !== $newUser) {
            $volunteer->setUser($newUser);
        }

        return $this;
    }

    public function getSalt()
    {
        // Nous n'utilisons pas de sel car Symfony gère automatiquement le hachage du mot de passe.
        // Vous pouvez laisser cette méthode vide.
    }

    public function eraseCredentials()
    {
        // Cette méthode est utilisée pour effacer les données sensibles de l'utilisateur.
        // Par exemple, si vous stockez le mot de passe en clair, vous pouvez le supprimer ici après l'avoir utilisé pour l'authentification.
        // Pour cet exemple, nous n'avons pas besoin de faire quoi que ce soit ici car Symfony gère automatiquement cela.
    }
}
