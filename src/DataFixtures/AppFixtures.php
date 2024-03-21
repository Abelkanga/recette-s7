<?php

namespace App\DataFixtures;

use App\Entity\Ingredien;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
   
   private Generator $faker; 

   private UserPasswordHasherInterface $hasher;


   public function __construct(UserPasswordHasherInterface $hasher)
   {
        $this->faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
   }
   
   

    public function load(ObjectManager $manager,): void
{
    // Ingrédients
    $ingredients = [];
    for ($i = 1; $i <= 50; $i++) {
        $ingredient = new Ingredien();
        $ingredient->setName($this->faker->word())
            ->setPrice(mt_rand(1, 100));

        $manager->persist($ingredient);
        $ingredients[] = $ingredient;
    }

    // Recettes
    for ($j = 0; $j < 25; $j++) {
        $recipe = new Recipe();
        $recipe->setName($this->faker->word())
            ->setTime(mt_rand(0, 1) == 1 ? mt_rand(1, 1440) : null)
            ->setNbPeople(mt_rand(0, 1) == 1 ? mt_rand(1, 50) : null)
            ->setDifficulty(mt_rand(0, 1) == 1 ? mt_rand(1, 5) : null)
            ->setDescription($this->faker->text(300))
            ->setPrice(mt_rand(0, 1) == 1 ? mt_rand(1, 1000) : null)
            ->setIsFavorite(mt_rand(0, 1) == 1 ? true : false);

        for ($k = 0; $k < mt_rand(5, 15); $k++) {
            $recipe->addIngredien($ingredients[mt_rand(0, count($ingredients) - 1)]);
        }

        $manager->persist($recipe);
    }


    //Users
    for ($i = 0; $i < 10 ; $i++) { 
        $user = new User();
        $user->setFullName($this->faker->name())
            ->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
            ->setEmail($this->faker->email())
            ->setRoles(['ROLES_USER']);
        
        $hashPassword = $this->hasher->hashPassword(
            $user,
            'password'
        );

        $user->setPassword($hashPassword);

        $manager->persist($user);

    }

    $manager->flush();
}

}
