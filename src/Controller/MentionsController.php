<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('mentions', name: 'mentions_')]
class MentionsController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('mentions/index.html.twig');
    }

    #[Route('/mentions', name: 'mentionsLegales')]
    public function mentions(): Response
    {
        return $this->render('mentions/mentions.html.twig');
    }

    #[Route('/confidentialite', name: 'confidentialite')]
    public function confidentialite(): Response
    {
        return $this->render('mentions/confidentialite.html.twig');
    }

    #[Route('/cookie', name: 'cookie')]
    public function cookie(): Response
    {
        return $this->render('mentions/cookie.html.twig');
    }
}
