<?php

namespace App\Controller\Admin;

use App\Entity\Allergy;
use App\Form\AllergyType;
use App\Repository\AllergyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/allergy', name: 'admin_allergy_')]
class AdminAllergyController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(AllergyRepository $allergyRepository): Response
    {
        return $this->render('admin/admin_allergy/list.html.twig', [
            'allergies' => $allergyRepository->findAll(),
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addAllergy(Request $request, ManagerRegistry $doctrine): Response
    {
        $allergie = new Allergy();

        $form = $this->createForm(AllergyType::class, $allergie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $allergie = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($allergie);
            $em->flush();

            return $this->redirectToRoute('admin_allergy_list');
        }


        return $this->render('admin/admin_allergy/addAllergy.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit')]
    public function editAllergy(Allergy $allergy, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(AllergyType::class, $allergy);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($allergy);
            $em->flush();

            return $this->redirectToRoute('admin_allergy_list');
        }

        return $this->render('admin/admin_allergy/editAllergy.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'delete')]
    public function deleteAllergy(Allergy $allergy, ManagerRegistry $doctrine)
    {
        
        $em = $doctrine->getManager();
        $em->remove($allergy);
        $em->flush(); 

        $this->addFlash('success', 'allergie supprimée avec succes');
        return $this->redirectToRoute('admin_allergy_list');
    }
}
