# TODO


Finalisation de la verison beta :

Jensone :
- Design d'Interface :
  - Homepage
  - Recettes > Recette
  - Commentaire workflow
  - Barre de recherche > QueryBuilder


Ekatrina :
-





---

Pour le 01/08

- Finaliser toutes interfaces (admin, recette, commentaire, etc)
- Masquer la fonction de modification des commentaires
- Masquer la fonction de modification des notes
- Ajouter la fonction de voir les commentaires
- Ajouter la fonction de voir les categories
- Ajouter la fonction de voir les notes
- Ajouter la fonction de voir les ingredients
****
---

Pour le 25/07

- Mettre des conditions d'affichage pour les commentaires
- Les templates (vues) dans le dossier templates/
  /page
    - accueil.html.twig
    - contact.html.twig
    - conditions-generales.html.twig

  /recette
    - index.html.twig
    - recette_one.html.twig (show)

- Les formulaires 
    CommentaireType.php

- EasyAdmin

--- 

Pour le 22/07

- Mettre à jour les entités avec 'created_at' et 'updated_at'
  - make:entity
  - doctrine:database:create
  - make:migration
  - doctrine:migrations:migrate
  - doctrine:fixtures:load

- Mettre en place les routes et templates du frontend (index, show)
  - make:controller
- Mettre des {{ dump() }} des données dans tous les templates

---