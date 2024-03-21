<?php

namespace App\Controller;

use App\Form\IngredienType;
use App\Repository\IngredienRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Ingredien;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredienController extends AbstractController
{
    #[Route('/ingredien', name: 'ingredien.index', methods: ['GET'])]
    public function index(IngredienRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $ingredien = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10 
        );

         return $this->render('pages/ingredien/index.html.twig', [
            'ingredien' => $ingredien
        ]);
    }

     #[Route('/ingredien/nouveau', name: 'ingredien.new', methods: ['GET', 'POST'])]
     public function new(Request $request, EntityManagerInterface $manager): Response
     {
         $ingredien = new Ingredien();
         $form = $this->createForm(IngredienType::class, $ingredien);
     
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
             $manager->persist($ingredien); 
             $manager->flush(); 
     
             $this->addFlash(
                 'success',
                 'Votre ingrédient a bien été créé !'
             );
     
             return $this->redirectToRoute('ingredien.index');
         }
     
         return $this->render('pages/ingredien/new.html.twig', [
             'form' => $form->createView()
         ]);
     }

   
      /**
     * This controller allow us to edit a new ingredien
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     * 
     */

     #[Route('/ingredien/edition/{id}', name: 'ingredien.edit', methods: ['GET', 'POST'])]
     
   
public function edit(Ingredien $ingredien, Request $request, EntityManagerInterface $manager): Response
{
    $form = $this->createForm(IngredienType::class, $ingredien);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
 
        $manager->persist($ingredien);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre ingrédient a été modifié avec succès !'
        );

        return $this->redirectToRoute('ingredien.index');
    }

    return $this->render('pages/ingredien/edit.html.twig', [
        'form' => $form->createView()
    ]);
}


    

    /**
     * This controller allows us to delete an ingredien
     * 
     * @param EntityManagerInterface $manager
     * @param Ingredien $ingredien
     * @return Response
     */
    #[Route('/ingredien/suppression/{id}', name : 'ingredien.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Ingredien $ingredien) : Response
    {
       
        $manager->remove($ingredien);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre ingrédient a été supprimé avec succès !'
        );
        return $this->redirectToRoute('ingredien.index');

    }
}
