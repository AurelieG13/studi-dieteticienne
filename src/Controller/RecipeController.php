<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Rating;
use App\Entity\Recipe;
use App\Form\CommentType;
use App\Form\RatingType;
use App\Form\RecipeType;
use App\Repository\RatingRepository;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/recipe', name: 'recipe_')]
class RecipeController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(RecipeRepository $recipeRepository): Response
    {
        $recipes = [];
        if(!$this->isGranted('ROLE_USER')){
            $recipes = $recipeRepository->findBy(['activeRecipe' => false]);
        }else{
            $recipes = $recipeRepository->findAll();
        }
        
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }

    #[Route('/details/{id<\d+>}', name: 'details')]
    public function details(
        RecipeRepository $recipeRepository,
        Recipe $recipe, 
        Request $request, 
        ManagerRegistry $doctrine,
        EntityManagerInterface $manager,
        RatingRepository $ratingRepository
        ): Response
    {
        $recipe = $recipeRepository->findOneById($recipe->getId());

        //Comments
        //Create a void comment 
        $comment = new Comment;
        if($this->getUser()) {
            $comment->setName($this->getUser()->getName())
                ->setFirstname($this->getUser()->getFirstname())
                ->setEmail($this->getUser()->getEmail());
        }

        
        //Create form
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        //Form processing
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                $comment = $commentForm->getData();
                $comment->setRecipies($recipe);
                

                //get content parentid
                $parentid = $commentForm->get('parentid')->getData();                
                
                $em = $doctrine->getManager();
                
                //get comment parent
                if($parentid != null){
                    $parent = $em->getRepository(Comment::class)->find($parentid);
                }

                //define parent
                $comment->setParent($parent ?? null);
                
                $em->persist($comment);

                $em->flush();
            

            $this->addFlash('success','votre commentaire a été ajouté avec succès');
            return $this->redirectToRoute('recipe_details', ['id' => $recipe->getId()]);
    }

    //Rating
        //Create a void rate 
        $rating = new Rating;
        
        //Create form
        $ratingForm = $this->createForm(RatingType::class, $rating);
        $ratingForm->handleRequest($request);



        //Form processing
        if ($ratingForm->isSubmitted() && $ratingForm->isValid()) {
                $rating->setRecipies($recipe)
                    ->setUser($this->getUser());
                
                $existingRate = $ratingRepository->findOneBy([
                    'user' => $this->getUser(),
                    'recipies' => $recipe
                ]);

                if(!$existingRate){
                    $em = $doctrine->getManager();
                    $em->persist($rating);
                }else{
                    $existingRate->setNote(
                        $ratingForm->getData()->getNote()
                    );


                }
                $em = $doctrine->getManager();
                $em->flush();
            

            $this->addFlash('success','votre note a été ajoutée avec succès');
            return $this->redirectToRoute('recipe_details', ['id' => $recipe->getId()]);
    }


        return $this->render('recipe/details.html.twig', [
            'recipe' => $recipe,
            'commentForm' => $commentForm->createView(),
            'ratingForm' => $ratingForm->createView(),
        ]);
    }

}
