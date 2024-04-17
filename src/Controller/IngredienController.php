<?php

namespace App\Controller;

use App\Entity\Ingredien;
use App\Form\IngredienType;
use App\Repository\IngredienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class IngredienController extends AbstractController
{
    // Route pour afficher la liste des ingrédients
    #[Route('/ingredien', name: 'ingredien_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(IngredienRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        // Paginer les ingrédients récupérés pour afficher un nombre limité par page
        $ingredien = $paginator->paginate(
            $repository->findBy(['user' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10 
        );

        // Rendre le template d'affichage de la liste des ingrédients
        return $this->render('pages/ingredien/index.html.twig', [
            'ingredien' => $ingredien
        ]);
    }

    // Route pour créer un nouvel ingrédient
    #[Route('/ingredien/nouveau', name: 'ingredien_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        // Créer un nouveau formulaire pour l'ingrédient
        $ingredien = new Ingredien();
        $form = $this->createForm(IngredienType::class, $ingredien);
        $form->handleRequest($request);
    
        // Gérer la soumission du formulaire et sauvegarder l'ingrédient
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $ingredien->setUser($user);
            $manager->persist($ingredien); 

            $manager->flush(); 
            $this->addFlash(
                 'success',
                 'Votre ingrédient a bien été créé !'
            );
            return $this->redirectToRoute('ingredien_index');
        }
    
        // Afficher le formulaire de création d'ingrédient
        return $this->render('pages/ingredien/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // Route pour éditer un ingrédient existant
    #[Route('/ingredien/edition/{id}', name: 'ingredien_edit', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER') and user === ingredien.getUser()")]
    public function edit(Ingredien $ingredien, Request $request, EntityManagerInterface $manager): Response
    {
        // Créer un formulaire pour l'édition de l'ingrédient existant
        $form = $this->createForm(IngredienType::class, $ingredien);
        $form->handleRequest($request);

        // Gérer la soumission du formulaire et sauvegarder les modifications
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ingredien);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre ingrédient a été modifié avec succès !'
            );

            return $this->redirectToRoute('ingredien_index');
        }

        // Afficher le formulaire d'édition de l'ingrédient
        return $this->render('pages/ingredien/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // Route pour supprimer un ingrédient
    #[Route('/ingredien/suppression/{id}', name: 'ingredien_delete', methods: ['GET'])]
    #[Security("is_granted('ROLE_USER') and user === ingredien.getUser()")]
    public function delete(EntityManagerInterface $manager, Ingredien $ingredien): Response
    {
        // Supprimer l'ingrédient de la base de données
        $manager->remove($ingredien);
        $manager->flush();

        // Rediriger vers la liste des ingrédients avec un message de succès
        $this->addFlash(
            'success',
            'Votre ingrédient a été supprimé avec succès !'
        );
        return $this->redirectToRoute('ingredien_index');
    }
}


