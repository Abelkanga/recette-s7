<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController 
{
   
    #[Route('/home', name: 'home_index', methods: ['GET'])]
    public function index(RecipeRepository $recipeRepository): Response 
    {
        return $this->render('pages/home.html.twig', [
            'recipe' => $recipeRepository->findPublicRecipe(3),
        ]
    
    );
    }
}