<?php

namespace App\Form;

use App\Entity\Mark;
use App\Entity\Recipe;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // Type de champ pour une liste déroulante
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Type de champ pour un bouton de soumission
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mark', ChoiceType::class, [ // Champ de type ChoiceType pour choisir la note
                'choices' => [ // Liste des choix possibles
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'attr' => [ // Attributs HTML du champ
                    'class' => 'form-select' // Classe CSS pour la mise en forme
                ],
                'label' => 'Noter la recette', // Étiquette du champ
                'label_attr' => [ // Attributs HTML de l'étiquette
                    'class' => 'form-label mt-4' // Classe CSS pour la mise en forme
                ]
            ])
            ->add('submit', SubmitType::class , [ // Champ de type SubmitType pour le bouton de soumission
                'attr' => [ // Attributs HTML du champ
                    'class' => 'btn btn-primary mt-4' // Classe CSS pour la mise en forme
                ],
                'label' => 'Noter la recette' // Étiquette du bouton de soumission
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mark::class, // Classe de l'objet associé au formulaire
        ]);
    }
}
