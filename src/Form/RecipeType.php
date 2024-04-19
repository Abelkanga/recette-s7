<?php

namespace App\Form;

use App\Entity\Ingredien;
use App\Entity\Recipe;
use App\Repository\IngredienRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Type de champ pour les entités Doctrine
use Symfony\Component\Form\AbstractType; // Classe abstraite pour la création de formulaires
use Symfony\Component\Form\Extension\Core\Type\CheckboxType; // Type de champ pour une case à cocher
use Symfony\Component\Form\Extension\Core\Type\IntegerType; // Type de champ pour un nombre entier
use Symfony\Component\Form\Extension\Core\Type\MoneyType; // Type de champ pour un montant monétaire
use Symfony\Component\Form\Extension\Core\Type\RangeType; // Type de champ pour une plage de valeurs
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Type de champ pour un bouton de soumission
use Symfony\Component\Form\Extension\Core\Type\TextareaType; // Type de champ pour un champ de texte multiligne
use Symfony\Component\Form\Extension\Core\Type\TextType; // Type de champ pour un champ de texte
use Symfony\Component\Form\FormBuilderInterface; // Interface pour la construction de formulaires
use Symfony\Component\OptionsResolver\OptionsResolver; // Classe pour la configuration des options des formulaires
use Symfony\Component\Validator\Constraints as Assert; // Contraintes de validation
use Vich\UploaderBundle\Form\Type\VichImageType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('time', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 1440
                ],
                'required' => false,
                'label' => 'Temps (en minutes)',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(1441)
                ]
            ])
            ->add('nbPeople', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 50
                ],
                'required' => false,
                'label' => 'Nombre de personnes',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(51)
                ]
            ])
            
            ->add('difficulty', RangeType::class, [
                'attr' => [
                    'class' => 'form-range',
                    'min' => 1,
                    'max' => 5
                ],
                'required' => false,
                'label' => 'Difficulté',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(5)
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 5
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('price', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control',
                 
                ],
                'required' => false,
                'label' => 'Prix',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(1001)
                ]
            ])
            ->add('isFavorite', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                 
                ],
                'required' => false,
                'label' => 'Favoris ?',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'constraints' => [
                    new Assert\NotNull()
                ]
            ])
            ->add('isPublic', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                 
                ],
                'required' => false,
                'label' => 'Public ?',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'constraints' => [
                    new Assert\NotNull()
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label'=> 'Image de la recette',
                'label_attr' => [
                    'class'=> 'form-label mt-4'
                ],
            ])
            // ->add('ingredien', EntityType::class, [
            //     'class' => Ingredien::class, 
            //     'query_builder' => function (IngredienRepository $r) { 
            //         return $r->createQueryBuilder('i')
            //             ->orderBy('i.name', 'ASC'); 
            //     },
            //     'label' => 'Les ingrédients',
            //     'label_attr' => [
            //         'class' => 'form-label mt-4'
            //     ],
            //     'choice_label' => 'name', 
            //     'multiple' => true,
            //     'expanded' => true, 
            // ]) code de base

                    //copilot,telegram code
                  ->add('ingredien', EntityType::class, [
                'class' => Ingredien::class, // Entité liée au champ
                'query_builder' => function (IngredienRepository $repository) {
                    return $repository->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC'); 
                },
                'label' => 'Les ingrédients', 
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false, 
            ]) 

        
            
        


            ->add('submit', SubmitType::class , [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Créer ma recette' 
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class, // Classe de l'objet associé au formulaire
        ]);
        
    }
}
