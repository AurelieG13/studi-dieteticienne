<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact', name: 'contact_')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'form')]
    public function index(
        Request $request, 
        EntityManagerInterface $manager
        ): Response
    {
        $contact = new Contact();
        if($this->getUser()) {
            $contact->setName($this->getUser()->getName())
                ->setFirstname($this->getUser()->getFirstname())
                ->setEmail($this->getUser()->getEmail());
        }
        

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', 'message envoyé avec succès');
            return $this->redirectToRoute('home');
            
    }
    
    return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
