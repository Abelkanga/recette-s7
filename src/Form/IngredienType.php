<?php

namespace App\Form;

use App\Entity\Ingredien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

// Définition du formulaire IngredienType
class IngredienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajout des champs du formulaire
        $builder
            ->add('name', TextType::class, [ // Champ de type TextType pour le nom
                'attr' => [ // Attributs HTML supplémentaires
                    'class' => 'form-control', // Classe CSS pour le champ
                    'minlength' => '2', // Longueur minimale du champ
                    'maxlength' => '50' // Longueur maximale du champ
                ],
                'label' => 'Nom', // Libellé du champ
                'label_attr' => [ // Attributs HTML supplémentaires pour le libellé
                    'class' => 'form-label mt-4' // Classe CSS pour le libellé
                ],
                'constraints' => [ // Contraintes de validation du champ
                    new Assert\Length(['min' => 2, 'max' => 50]), // Longueur minimale et maximale du nom
                    new Assert\NotBlank() // Le champ ne doit pas être vide
                ]
            ])
            ->add('price', MoneyType::class, [ // Champ de type MoneyType pour le prix
                'attr' => [ // Attributs HTML supplémentaires
                    'class' => 'form-control', // Classe CSS pour le champ
                ],
                'label' => 'Prix', // Libellé du champ
                'label_attr' => [ // Attributs HTML supplémentaires pour le libellé
                    'class' => 'form-label mt-4' // Classe CSS pour le libellé
                ],
                'constraints' => [ // Contraintes de validation du champ
                    new Assert\Positive(), // Le prix doit être positif
                    new Assert\LessThan(200) // Le prix doit être inférieur à 200
                ]
            ])
            ->add('submit', SubmitType::class, [ // Bouton de soumission du formulaire
                'attr' => [ // Attributs HTML supplémentaires
                    'class' => 'btn btn-primary mt-4' // Classe CSS pour le bouton
                ],
                'label' => 'Créer mon ingrédient' // Libellé du bouton
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configuration par défaut du formulaire
        $resolver->setDefaults([
            'data_class' => Ingredien::class, // Classe des données du formulaire
        ]);
    }
}
