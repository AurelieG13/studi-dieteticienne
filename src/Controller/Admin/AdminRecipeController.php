<?php

namespace App\Controller\Admin;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Recipe;
use App\Form\RecipeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/recipe', name: 'admin_recipe_')]
class AdminRecipeController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();
        return $this->render('admin/admin_recipe/list.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addRecipe(Request $request, ManagerRegistry $doctrine): Response
    {
        $recipe = new Recipe();

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('admin_recipe_list');
        }


        return $this->render('admin/admin_recipe/addRecipe.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit')]
    public function editRecipe(Recipe $recipe, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('admin_recipe_list');
        }

        return $this->render('admin/admin_recipe/editRecipe.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // #[Route('/delete/{id<\d+>}', name: 'delete')]
    // public function deleteAllergy(Allergy $allergy, ManagerRegistry $doctrine)
    // {
        
    //     $em = $doctrine->getManager();
    //     $em->remove($allergy);
    //     $em->flush(); 

    //     $this->addFlash('success', 'allergie supprimée avec succes');
    //     return $this->redirectToRoute('manager_allergy_list');
    // }
}
