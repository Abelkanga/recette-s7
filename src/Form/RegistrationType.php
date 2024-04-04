<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType; // Classe abstraite pour la création de formulaires
use Symfony\Component\Form\Extension\Core\Type\EmailType; // Type de champ pour une adresse email
use Symfony\Component\Form\Extension\Core\Type\PasswordType; // Type de champ pour un mot de passe
use Symfony\Component\Form\Extension\Core\Type\RepeatedType; // Type de champ pour la répétition d'un champ
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Type de champ pour un bouton de soumission
use Symfony\Component\Form\Extension\Core\Type\TextType; // Type de champ pour un champ de texte
use Symfony\Component\Form\FormBuilderInterface; // Interface pour la construction de formulaires
use Symfony\Component\OptionsResolver\OptionsResolver; // Classe pour la configuration des options des formulaires
use Symfony\Component\Validator\Constraints as Assert; // Contraintes de validation




class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Nom / Prénom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'required' => false,
                'label' => 'Pseudo (Facultatif)',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '180',
                ],
                'label' => 'Adresse email',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class, // Type de champ pour le mot de passe
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.', // Message affiché en cas de non-correspondance des mots de passe
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire', // Étiquette du bouton de soumission
                'attr' => [
                    'class' => 'btn btn-primary mt-4' // Attributs HTML pour le bouton de soumission
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, // Classe de l'objet associé au formulaire
        ]);
    }
}
