<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $prepareTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $restTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $cookingTime = null;

    #[ORM\ManyToMany(targetEntity: Allergy::class, inversedBy: 'recipies')]
    private ?Collection $allergies;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Ingredient::class)]
    private Collection $ingredients;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Diet::class)]
    private Collection $diet;

    #[ORM\ManyToMany(targetEntity: Step::class, inversedBy: 'recipes')]
    private Collection $steps;

    public function __construct()
    {
        $this->allergies = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->diet = new ArrayCollection();
        $this->steps = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrepareTime(): ?\DateTimeInterface
    {
        return $this->prepareTime;
    }

    public function setPrepareTime(\DateTimeInterface $prepareTime): self
    {
        $this->prepareTime = $prepareTime;

        return $this;
    }

    public function getRestTime(): ?\DateTimeInterface
    {
        return $this->restTime;
    }

    public function setRestTime(\DateTimeInterface $restTime): self
    {
        $this->restTime = $restTime;

        return $this;
    }

    public function getCookingTime(): ?\DateTimeInterface
    {
        return $this->cookingTime;
    }

    public function setCookingTime(\DateTimeInterface $cookingTime): self
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    /**
     * @return Collection<int, Allergy>
     */
    public function getAllergies(): Collection
    {
        return $this->allergies;
    }

    public function addAllergy(Allergy $allergy): self
    {
        if (!$this->allergies->contains($allergy)) {
            $this->allergies->add($allergy);
        }

        return $this;
    }

    public function removeAllergy(Allergy $allergy): self
    {
        $this->allergies->removeElement($allergy);

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecipe() === $this) {
                $ingredient->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Diet>
     */
    public function getDiet(): Collection
    {
        return $this->diet;
    }

    public function addDiet(Diet $diet): self
    {
        if (!$this->diet->contains($diet)) {
            $this->diet->add($diet);
            $diet->setRecipe($this);
        }

        return $this;
    }

    public function removeDiet(Diet $diet): self
    {
        if ($this->diet->removeElement($diet)) {
            // set the owning side to null (unless already changed)
            if ($diet->getRecipe() === $this) {
                $diet->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        $this->steps->removeElement($step);

        return $this;
    }
}
