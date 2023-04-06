<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/admin/ingredient', name: 'admin_ingredient_')]
class AdminIngredientController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(IngredientRepository $ingredientRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $ingredients = $paginator->paginate(
            $ingredientRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/admin_ingredient/list.html.twig', [
            'ingredients' => $ingredients,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addIngredient(Request $request, ManagerRegistry $doctrine): Response
    {
        $ingredient = new Ingredient();

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($ingredient);
            $em->flush();

            return $this->redirectToRoute('admin_ingredient_list');
        }


        return $this->render('admin/admin_ingredient/addIngredient.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit')]
    public function editIngredient(Ingredient $ingredient, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($ingredient);
            $em->flush();

            return $this->redirectToRoute('admin_ingredient_list');
        }

        return $this->render('admin/admin_ingredient/editIngredient.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'delete')]
    public function deleteIngredient(Ingredient $ingredient, ManagerRegistry $doctrine)
    {
        
        $em = $doctrine->getManager();
        $em->remove($ingredient);
        $em->flush(); 

        $this->addFlash('success', 'ingredient supprimé avec succes');
        return $this->redirectToRoute('admin_ingredient_list');
    }
}
