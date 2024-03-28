<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    // Route pour éditer le profil de l'utilisateur
    #[Route('/utilisateur/edition/{id}', name: 'user.edit')]
    public function edit(User $user): Response
    {
        // Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
        if (!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }
        
        // Vérifier si l'utilisateur actuel est autorisé à modifier le profil
        if (!$this->getUser() === $user) {
            return $this->redirectToRoute('recipe.index');
        }

        // Créer un formulaire pour l'édition du profil de l'utilisateur
        $form = $this->createForm(UserType::class, $user);

        // Rendre le template d'édition du profil de l'utilisateur
        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // UserRepository est injecté dans le contrôleur via le constructeur
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
