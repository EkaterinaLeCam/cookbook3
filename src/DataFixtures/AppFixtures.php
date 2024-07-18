<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Ingredient;
use App\Entity\Note;
use App\Entity\Recette;
use Faker\Factory;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        $admin = new Utilisateur();
        $admin
            ->setEmail('admin@admin.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('$2y$13$06qGI9vZ/LSinP7JaVjzM.Ug1S8fBqCq3MMIjJRijztnRBu81o4iq')
            ->setNom('Admin')
            ->setPrenom('CookBook')
        ;
        $manager->persist($admin);

        // 50 utilisateurs
        $userList = [];
        for ($i=0; $i < 50; $i++) { 
            $firstname = $faker->firstName;
            $user = new Utilisateur();
            $user
                ->setEmail($firstname. $i . $faker->randomElement(['@gmail.com', '@yahoo.fr', '@hotmail.fr']) )
                ->setPassword('$2y$13$06qGI9vZ/LSinP7JaVjzM.Ug1S8fBqCq3MMIjJRijztnRBu81o4iq')
                ->setNom($faker->lastName)
                ->setPrenom($firstname)
            ;
            array_push($userList, $user);
            $manager->persist($user);
        }

        // 1000 indgrédients
        $ingredientList = [];
        for ($i=0; $i < 1000; $i++) { 
            $ingredient = new Ingredient();
            $ingredient
                ->setNom($faker->word)
                ->setImage($faker->imageUrl(400, 400, 'food'))
            ;
            array_push($ingredientList, $ingredient);
            $manager->persist($ingredient);
        }

        // Categories
        $categorieList = [];
        $categories = [
            'Petit déjeuner',
            'Apéro',
            'Entrée',
            'Plat',
            'Dessert',
            'Boisson'
        ];

        for ($i=0; $i < count($categories); $i++) { 
            $categorie = new Categorie();
            $categorie
                ->setNom($categories[$i])
            ;
            array_push($categorieList, $categorie);
            $manager->persist($categorie);
        }

        // 500 recettes
        $recetteList = [];
        for ($i=0; $i < 500; $i++) { 
            $recette = new Recette();
            $recette
                ->setNom($faker->sentence(4))
                ->setPreparation($faker->numberBetween(5, 200))
                ->setCuisson($faker->numberBetween(0, 200))
                ->setRepos($faker->numberBetween(0, 200))
                ->setPays($faker->country)
                ->setInstruction($faker->paragraphs(3, true))
                ->setBrouillon($faker->boolean(40))
                ->setImage($faker->imageUrl(800, 400, 'food'))
                ->setCategorie($faker->randomElement($categorieList))
                ->addIngredient($faker->randomElement($ingredientList))
                ->addIngredient($faker->randomElement($ingredientList))
                ->addIngredient($faker->randomElement($ingredientList))
                ;

            ;
            array_push($recetteList, $recette);
            $manager->persist($recette);
        }

        // 400 notes
        for ($i=0; $i < 400; $i++) { 
            $note = new Note();
            $note
                ->setEtoile($faker->numberBetween(1, 5))
                ->setRecette($faker->randomElement($recetteList))
                ->setAuteur($faker->randomElement($userList))
            ;
            $manager->persist($note);
        }

        // 300 commentaires
        for ($i=0; $i < 300; $i++) { 
            $commentaire = new Commentaire();
            $commentaire
                ->setContenu($faker->word(30))
                ->setStatut($faker->boolean(80))
                ->setRecette($faker->randomElement($recetteList))
                ->setAuteur($faker->randomElement($userList))
            ;
            $manager->persist($commentaire);
        }




        $manager->flush();
    }
}
