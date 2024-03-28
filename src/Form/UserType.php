<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType; // Classe abstraite pour la création de formulaires
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Type de champ pour un bouton de soumission
use Symfony\Component\Form\Extension\Core\Type\TextType; // Type de champ pour un champ de texte
use Symfony\Component\Form\FormBuilderInterface; // Interface pour la construction de formulaires
use Symfony\Component\OptionsResolver\OptionsResolver; // Classe pour la configuration des options des formulaires
use Symfony\Component\Validator\Constraints as Assert; // Contraintes de validation

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
