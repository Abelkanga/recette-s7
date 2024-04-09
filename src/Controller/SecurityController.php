<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    // Route pour afficher le formulaire de connexion
    #[Route('/', name: 'security_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user) {
            flash()->addSuccess('Bienvenue  monsieur ' . $user->getFullName());
            return $this->redirectToRoute('home_index');
        }

        // Rendre le template d'affichage du formulaire de connexion
        return $this->render('pages/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    // Route pour gérer la déconnexion de l'utilisateur
    #[Route('/deconnexion', name: 'security_logout')]
    public function logout()
    {
        // Rien à faire ici, Symfony s'occupe de la déconnexion automatiquement
    }


    // Route pour afficher le formulaire d'inscription et traiter la création de compte
    #[Route('/inscription', name: 'security_registration', methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {

        // Créer un nouvel utilisateur avec le rôle par défaut "ROLES_USER"
        $user = new User();
        $user->setRoles(['ROLES_USER']);

        // Créer un formulaire d'inscription pour l'utilisateur
        $form = $this->createForm(RegistrationType::class, $user);

        // Traiter la soumission du formulaire et enregistrer l'utilisateur
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $user->getPassword();
            // dd($plainPassword);
            $hashPassword = $userPasswordHasherInterface->hashPassword($user, $plainPassword);
            $user->setPassword($hashPassword);
            $manager->persist($user);
            $manager->flush();

            flash()->addSuccess('Votre compte a été créé avec succès. ');
            // Rediriger vers la page de connexion après la création du compte
            return $this->redirectToRoute('security_login');
        }

        // Rendre le template d'affichage du formulaire d'inscription
        return $this->render('pages/security/registration.html.twig', [
            'form' => $form
        ]);
    }
}
