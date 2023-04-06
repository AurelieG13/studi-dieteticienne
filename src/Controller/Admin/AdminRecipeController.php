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
use Knp\Component\Pager\PaginatorInterface;

#[Route('/admin/recipe', name: 'admin_recipe_')]
class AdminRecipeController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(RecipeRepository $recipeRepository,  PaginatorInterface $paginator, Request $request): Response
    {
        $recipes = $paginator->paginate(
            $recipeRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/admin_recipe/list.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/active/{id<\d+>}', name: 'active')]
    public function active(Recipe $recipe, ManagerRegistry $doctrine): Response
    {
        $recipe->setActiveRecipe(($recipe->getActiveRecipe()) ? false : true);
        $em = $doctrine->getManager();
        $em->persist($recipe);
        $em->flush();

        return new Response ("true");
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

    #[Route('/delete/{id<\d+>}', name: 'delete')]
    public function deleteRecipe(Recipe $recipe, ManagerRegistry $doctrine)
    {
        
        $em = $doctrine->getManager();
        $em->remove($recipe);
        $em->flush(); 

        $this->addFlash('success', 'Recette supprimée avec succes');
        return $this->redirectToRoute('admin_recipe_list');
    }
}
