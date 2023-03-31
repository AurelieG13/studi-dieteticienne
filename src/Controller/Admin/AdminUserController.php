<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user', name: 'admin_user_')]
class AdminUserController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/admin_user/list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/addPatient', name: 'addPatient')]
    public function addPatient(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        ManagerRegistry $doctrine
    ): Response
    {

        $user = new User($userPasswordHasher);
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            
            return $this->redirectToRoute('admin_user_list');
            $this->addFlash('success', 'Profil Patient ajouté avec succès');
            
        }

        return $this->render('admin/admin_user/register.html.twig', [
            'admin_register_form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id<\d+>}', name: 'editPatient')]
    public function edit(
        User $user,
        Request $request,
        ManagerRegistry $doctrine
        ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();
            
            return $this->redirectToRoute('admin_user_list');
        }
        return $this->render('admin/admin_user/edit.html.twig', [
            'admin_edit_form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'deletePatient')]
    public function deleteAllergy(User $user, ManagerRegistry $doctrine)
    {
        
        $em = $doctrine->getManager();
        $em->remove($user);
        $em->flush(); 

        $this->addFlash('success', 'Patient supprimé avec succes');
        return $this->redirectToRoute('admin_user_list');
    }
}
