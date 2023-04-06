<?php

namespace App\Controller\Admin;

use App\Entity\Step;
use App\Form\StepType;
use App\Repository\StepRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/admin/step', name: 'admin_step_')]
class AdminStepController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(StepRepository $stepRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $steps = $paginator->paginate(
            $stepRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/admin_step/list.html.twig', [
            'steps' => $steps,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addStep(Request $request, ManagerRegistry $doctrine): Response
    {
        $step = new Step();

        $form = $this->createForm(StepType::class, $step);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $step = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($step);
            $em->flush();

            return $this->redirectToRoute('admin_step_list');
        }


        return $this->render('admin/admin_step/addStep.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit')]
    public function editStep(Step $step, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(StepType::class, $step);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($step);
            $em->flush();

            return $this->redirectToRoute('admin_step_list');
        }

        return $this->render('admin/admin_step/editstep.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'delete')]
    public function deleteAllergy(Step $step, ManagerRegistry $doctrine)
    {
        
        $em = $doctrine->getManager();
        $em->remove($step);
        $em->flush(); 

        $this->addFlash('success', 'étape supprimée avec succes');
        return $this->redirectToRoute('admin_step_list');
    }
}
