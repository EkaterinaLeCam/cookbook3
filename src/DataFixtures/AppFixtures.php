<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Ingredient;
use App\Entity\Mesure;
use App\Entity\Note;
use App\Entity\Recette;
use Faker\Factory;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Cocur\Slugify\Slugify;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $slug = new Slugify();

        $admin = new Utilisateur();
        $admin
            ->setEmail('admin@admin.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('$2y$13$06qGI9vZ/LSinP7JaVjzM.Ug1S8fBqCq3MMIjJRijztnRBu81o4iq')
            ->setNom('Admin')
            ->setPrenom('CookBook');
        $manager->persist($admin);

        // 50 utilisateurs
        $userList = [];
        for ($i = 0; $i < 10; $i++) {
            $firstname = $faker->firstName;
            $user = new Utilisateur();
            $user
                ->setEmail($firstname . $i . $faker->randomElement(['@gmail.com', '@yahoo.fr', '@hotmail.fr']))
                ->setPassword('$2y$13$06qGI9vZ/LSinP7JaVjzM.Ug1S8fBqCq3MMIjJRijztnRBu81o4iq')
                ->setNom($faker->lastName)
                ->setPrenom($firstname);
            array_push($userList, $user);
            $manager->persist($user);
        }

        // 100 indgrédients
        $ingredientList = [];
        $igredientsFr = [
            'Citronniçois',
            'Clémentine',
            'Kiwi',
            'Mandarine',
            'Noix',
            'Orange',
            'Poire',
            'Pomme',
            'Betterave',
            'Brocoli',
            'Carotte',
            'Céléri',
            'Chou',
            'Chou de Bruxelles',
            'Chou-fleur',
            'Endive',
            'Mâche',
            'Navet',
            'Oignon',
            'Panais',
            'Poireau',
            'Pommedeterre',
            'Potiron',
            'Rutabaga',
            'Salsifi',
            'Scarole',
            'Topinambour',
            'Fenouil',
            'Frisée',
            'Asperge',
            'Crosne',
            'Laitue pommée',
            'Pomme de terre',
            'Pomme',
            'Rhubarbe',
            'Blette',
            'Épinard',
            'Petitpois',
            'Radis',
            'Fraise',
            'Aubergine',
            'Concombre',
            'Courgette',
            'Fève',
            'Radis',
            'Tomate',
            'Abricot',
            'Cassis',
            'Cerise',
            'Framboise',
            'Melon',
            'Mûre',
            'Prune',
            'Artichaut',
            'Céleri',
            'Haricotvert',
            'Laitue feuille de chêne',
            'Poivron',
            'Brugnon',
            'Figue',
            'Groseille',
            'Myrtille',
            'Nectarine',
            'Pastèque',
            'Pêche',
            'Prune',
            'Maïs',
            'Mirabelle',
            'Noisette',
            'Salade',
            'Raisin',
            'Châtaigne',
            'Coing',
            'Courge',
            'Tomate',
            'Cardon'
        ];
        for ($i = 0; $i < count($igredientsFr); $i++) {
            $ingredient = new Ingredient();
            $ingredient
                ->setNom($igredientsFr[$i])
                ->setImage($faker->imageUrl(400, 400, 'food'));
            if ($i < 10) {
                array_push($ingredientList, $ingredient);
            }
            $manager->persist($ingredient);
        }

        // MEsures 
        $mesureList = [];
        foreach ($ingredientList as $value) {
            for ($i = 10; $i < 5; $i++) {
                $mesure = new Mesure();
                $mesure
                    ->setQuantite($i * 10)
                    ->setMesure($faker->randomElement(['gr', 'kg', 'pièce', 'l', 'ml']))
                    ->addIngredient($value);
                array_push($mesureList, $mesure);
                $manager->persist($mesure);
            }
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

        for ($i = 0; $i < count($categories); $i++) {
            $categorie = new Categorie();
            $categorie
                ->setNom($categories[$i]);
            array_push($categorieList, $categorie);
            $manager->persist($categorie);
        }

        // 50 recettes
        $recetteList = [];
        for ($i = 0; $i < 50; $i++) {
            $ingr = $faker->randomElement($ingredientList);
            $mesure = new Mesure();
            $mesure
                ->setQuantite($faker->numberBetween(0, 100))
                ->setMesure($faker->randomElement(['gr', 'kg', 'pièce', 'l', 'ml']))
                ->addIngredient($ingr);
            $manager->persist($mesure);

            $nom = $faker->sentence(4);
            $slugOutput = $slug->slugify($nom);
            $recette = new Recette();
            $recette
                ->setNom($nom)
                ->setSlug($slugOutput)
                ->setPreparation($faker->numberBetween(5, 200))
                ->setCuisson($faker->numberBetween(0, 200))
                ->setRepos($faker->numberBetween(0, 200))
                ->setPays($faker->country)
                ->setInstruction($faker->paragraphs(3, true))
                ->setBrouillon($faker->boolean(40))
                ->setImage($faker->imageUrl(800, 400, 'food'))
                ->setCategorie($faker->randomElement($categorieList));

                foreach ($mesureList as $value) {
                    $recette->addMesure($value);
                }

            ;
            array_push($recetteList, $recette);
            $manager->persist($recette);
        }

        // 50 notes
        for ($i = 0; $i < 50; $i++) {
            $note = new Note();
            $note
                ->setEtoile($faker->numberBetween(1, 5))
                ->setRecette($faker->randomElement($recetteList))
                ->setAuteur($faker->randomElement($userList));
            $manager->persist($note);
        }

        // 50 commentaires
        for ($i = 0; $i < 50; $i++) {
            $commentaire = new Commentaire();
            $commentaire
                ->setContenu($faker->word(30))
                ->setStatut($faker->boolean(80))
                ->setRecette($faker->randomElement($recetteList))
                ->setAuteur($faker->randomElement($userList));
            $manager->persist($commentaire);
        }


        $manager->flush();
    }
}
