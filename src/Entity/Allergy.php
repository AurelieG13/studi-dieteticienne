<?php

namespace App\Entity;

use App\Repository\AllergyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AllergyRepository::class)]
class Allergy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'allergies')]
    private ?Collection $users;

    #[ORM\ManyToMany(targetEntity: Recipe::class, mappedBy: 'allergies')]
    private ?Collection $recipies;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->recipies = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addAllergy($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);
        $user->removeAllergy($this);

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipies(): Collection
    {
        return $this->recipies;
    }

    public function addRecipy(Recipe $recipy): self
    {
        if (!$this->recipies->contains($recipy)) {
            $this->recipies->add($recipy);
            $recipy->addAllergy($this);
        }

        return $this;
    }

    public function removeRecipy(Recipe $recipy): self
    {
        $this->recipies->removeElement($recipy);
        $recipy->removeAllergy($this);

        return $this;
    }
}
