<?php

namespace App\Controller;

use App\Form\EditAllergyFormType;
use App\Form\EditDietFormType;
use App\Form\EditProfileFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/profile', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('profile/index.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/infos', name: 'infos')]
    public function infos(): Response
    {
        $user = $this->getUser();

        return $this->render('profile/infos.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit_user')]
    public function editUser(
        Request $request,
        ManagerRegistry $doctrine,
        ): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $em = $doctrine->getManager();
                $em->persist($user);
                $em->flush();
            

            $this->addFlash('success','votre profil a été modifié avec succès');
            return $this->redirectToRoute('profile_home');
        }
        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/editallergy/{id<\d+>}', name: 'edit_user_allergy')]
    public function editUserAllergy(
        Request $request,
        ManagerRegistry $doctrine
        ): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditAllergyFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success','votre profil a été modifié avec succès');
            return $this->redirectToRoute('profile_home');
        }

        return $this->render('profile/editAllergy.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/editdiet/{id<\d+>}', name: 'edit_user_diet')]
    public function editUserDiet(
        Request $request,
        ManagerRegistry $doctrine
        ): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditDietFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success','votre profil a été modifié avec succès');
            return $this->redirectToRoute('profile_home');
        }

        return $this->render('profile/editDiet.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
