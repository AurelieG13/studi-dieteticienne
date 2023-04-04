<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/recipe', name: 'recipe_')]
class RecipeController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(RecipeRepository $recipeRepository): Response
    {
        $recipes = [];
        if(!$this->isGranted('ROLE_USER')){
            $recipes = $recipeRepository->findBy(['activeRecipe' => false]);
        }else{
            $recipes = $recipeRepository->findAll();
        }
        
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }

    #[Route('/details/{id<\d+>}', name: 'details')]
    public function details(RecipeRepository $recipeRepository, Recipe $recipe): Response
    {
        $recipe = $recipeRepository->findOneById($recipe->getId());
        return $this->render('recipe/details.html.twig', [
            'recipe' => $recipe
        ]);
    }

}
