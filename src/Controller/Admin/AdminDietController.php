<?php

namespace App\Controller\Admin;

use App\Entity\Diet;
use App\Form\DietType;
use App\Repository\DietRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/diet', name: 'admin_diet_')]
class AdminDietController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(DietRepository $dietRepository): Response
    {
        return $this->render('admin/admin_diet/list.html.twig', [
            'diets' => $dietRepository->findAll(),
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addDiet(Request $request, ManagerRegistry $doctrine): Response
    {
        $diet = new Diet();

        $form = $this->createForm(DietType::class, $diet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $diet = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($diet);
            $em->flush();

            return $this->redirectToRoute('admin_diet_list');
        }


        return $this->render('admin/admin_diet/addDiet.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit')]
    public function editDiet(Diet $diet, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(DietType::class, $diet);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($diet);
            $em->flush();

            return $this->redirectToRoute('admin_diet_list');
        }

        return $this->render('admin/admin_diet/editDiet.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'delete')]
    public function deleteDiet(Diet $diet, ManagerRegistry $doctrine)
    {
        
        $em = $doctrine->getManager();
        $em->remove($diet);
        $em->flush(); 

        $this->addFlash('success', 'régime supprimé avec succes');
        return $this->redirectToRoute('admin_diet_list');
    }
}
