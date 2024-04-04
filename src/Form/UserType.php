<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\OptionsResolver\OptionsResolver; 
use Symfony\Component\Validator\Constraints as Assert; 

class UserType extends AbstractType
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
                'label' => 'Nom / Prénom', // Étiquette du champ
                'label_attr' => [
                    'class' => 'form-label mt-4' // Attributs HTML pour l'étiquette
                ],
                'constraints' => [
                    new Assert\NotBlank(), // Contrainte : le champ ne doit pas être vide
                    new Assert\Length(['min' => 2, 'max' => 50]) // Contrainte : longueur minimale et maximale du champ
                ]
            ])
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2', // Typo: devrait être "minlength"
                    'maxlenght' => '50', // Typo: devrait être "maxlength"
                ],
                'required' => false, // Champ facultatif
                'label' => 'Pseudo (Facultatif)', // Étiquette du champ
                'label_attr' => [
                    'class' => 'form-label mt-4' // Attributs HTML pour l'étiquette
                ],
                'constraints' => [
                    new Assert\NotBlank(), // Contrainte : le champ ne doit pas être vide
                    new Assert\Length(['min' => 2, 'max' => 50]) // Contrainte : longueur minimale et maximale du champ
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('submit', SubmitType::class, [
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
