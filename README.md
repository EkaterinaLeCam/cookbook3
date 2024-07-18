# TODO

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