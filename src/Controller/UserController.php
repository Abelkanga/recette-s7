<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;



class UserController extends AbstractController
{
    /**
     * This controller allow us to edit user's profile
     * @param Request $request
     * @param EntityManagerInterface  $manager
     * @return Response
     */
    
    
    // Route pour éditer le profil de l'utilisateur
    #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods:['GET', 'POST'])]
    public function edit(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
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

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();
    
                $this->addFlash(
                    'success',
                    'Les informations de votre compte ont bien été modifiées.'
                );

                return $this->redirectToRoute('recipe_index');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );

            }
            
           

        }

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


    #[Route('/utilisateur/edition-mot-de-passe/{id}', 'user.edit.password', methods: ['GET', 'POST'])]
    public function editPassword(User $user, Request $request, EntityManagerInterface $manager ,UserPasswordHasherInterface $hasher) : Response 
    {
        
        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          
            if ($hasher->isPasswordValid($user, $form->getData()['plainPassword']))
            {
                $user->setPassword(
                   $hasher->hashPassword(
                    $user,
                    $form->getData()['newPassword']
                   )
                );

               
                
                $this->addFlash(
                    'success',
                    'Le mot de passe a été modifié.'
                );

                 
                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('recipe_index');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect'
                );
            }


        }


        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
