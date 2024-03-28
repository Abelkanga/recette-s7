<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Repository\RecipeRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Form\MarkType;
use App\Repository\MarkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 

class RecipeController extends AbstractController
{
    // Route pour afficher la liste des recettes
    #[Route('/recette', name: 'recipe.index', methods: ['GET'])]
    public function index(RecipeRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        // Paginer les recettes récupérées pour afficher un nombre limité par page
        $recipes = $paginator->paginate(
            $repository->findBy(['user' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10
            
        );

        // Rendre le template d'affichage de la liste des recettes
        return $this->render('pages/recipe/index.html.twig', [
            'recipe' => $recipes,
        ]);
    }

    // Route pour afficher une recette spécifique et gérer les notes
    #[Route('/recette/{id}', name: 'recipe.show', methods: ['GET', 'POST'])]
    public function show(Recipe $recipe, Request $request, MarkRepository $markRepository, EntityManagerInterface $manager) : Response
    {
        // Créer un formulaire pour saisir une note sur la recette
        $mark = new Mark();
        $form = $this->createForm(MarkType::class, $mark);

        // Traiter la soumission du formulaire et enregistrer la note
        if ($form->isSubmitted() && $form->isValid()) {
            $mark->setUser($this->getUser())
                ->setRecipe($recipe);
            
            $existingMark = $markRepository->findOneBy([
                'user' => $this->getUser(),
                'recipe' => $recipe
            ]);

            if (!$existingMark) {
                $manager->persist($mark);
            } else {
                $existingMark->setMark(
                    $form->getData()->getMark()
                );
            }
            
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre note a bien été prise en compte.'
            );
           return $this->redirectToRoute('recipe.show', ['id' => $recipe->getId()]);
        }

        // Afficher la recette et le formulaire de saisie de note
        return $this->render('pages/recipe/show.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView()
        ]);
    }

    // Route pour créer une nouvelle recette
    #[Route('/recette/creation', name: 'recipe.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response 
    {
        // Créer un nouveau formulaire pour la création de recette
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        // Traiter la soumission du formulaire et enregistrer la recette
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $recipe->setUser($this->getUser());
            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a été créée avec succès !'
            );

            return $this->redirectToRoute('recipe.index');
        }

        // Afficher le formulaire de création de recette
        return $this->render('pages/recipe/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // Route pour éditer une recette existante
    #[Route('/recette/edition/{id}', name: 'recipe.edit', methods: ['GET', 'POST'])]
    public function edit(Recipe $recipe, Request $request, EntityManagerInterface $manager): Response
    {
        // Créer un formulaire pour l'édition de la recette
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        // Traiter la soumission du formulaire et enregistrer les modifications
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a été modifiée avec succès !'
            );

            return $this->redirectToRoute('recipe.index');
        }

        // Afficher le formulaire d'édition de recette
        return $this->render('pages/recipe/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // Route pour supprimer une recette
    #[Route('/recette/suppression/{id}', name: 'recipe.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Recipe $recipe) : Response
    {
        // Supprimer la recette de la base de données
        $manager->remove($recipe);
        $manager->flush();

        // Rediriger vers la liste des recettes avec un message de succès
        $this->addFlash(
            'success',
            'Votre recette a été supprimée avec succès !'
        );
        return $this->redirectToRoute('recipe.index');
    }
}

