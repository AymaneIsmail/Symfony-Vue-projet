# VueJS/Symfony projet

Le but du projet était de réaliser un CRUD à l'aide d'un framework backend et de faire un rendu côté client avec un framwork front en utilisant des appels ajax pour récupérer les données depuis le serveur.


# Installation du projet
	Lancer les commandes suivantes :
- **composer install**
	> Installe les dépendances
- **php bin/console doctrine:database:create** 
	>  Cette commande crée la base de donnée.
- **php bin/console make:migration** 
	>  Cette commande crée la base de donnée.
- **php bin/console doctrine:migration:migrate** 
	>  Cette commande crée la base de donnée.
	>  Une erreur s'affichera : lancer la commande suivante
- **php bin/console doctrine:fixtures:load** 
	> Crée un jeux de fausse données.
- **symfony serve**
	> Lance le serveur symfony.

## Structure du projet

```
project
│    
│
└───src
│   │
│   └───Controller
│       │   RecetteController.php
...
│   │
│   └───templates
``` 
Le dossier **src** contient un sous dossier **Controller** dans la quel se trouve toutes la logique de l'application 
## Routes
Une fois le serveur lancé aller dans http://localhost:8000/recette
- http://localhost:8000/recette/show
	>Renvoie la liste des toutes les recettes en JSON 
- http://localhost:8000/recette/show
	>Renvoie une recette en JSON selon l'id 
- http://localhost:8000/recette/edit/{id}
	>Renvoie sur la page édit selon l'id de la recette
- http://localhost:8000/recette/delete/{id}
	>Supprime une recette selon son id

