## About Api-touri

api-touri est une api qui permet de gérer les réservations des touristes dans les hotels et les restaurants.

## Installation et lancement avec docker

### Prérequis

-   Docker
-   Docker-compose

### Installation

-   Cloner le projet
-   Se placer dans le dossier du projet
-   Lancer la commande `docker-compose up -d`

### Lancement

-   Se placer dans le dossier du projet
-   Lancer la commande `docker-compose up -d`

### Arrêt

-   Se placer dans le dossier du projet
-   Lancer la commande `docker-compose down`

## Installation et lancement sans docker

### Prérequis

-   PHP 8.1^
-   Composer
-   MySQL 8.0^
-   Node 14.17.6^
-   NPM 6.14.15^

### Installation

-   Cloner le projet
-   Se placer dans le dossier du projet
-   Lancer la commande `composer install`
-   Lancer la commande `npm install`
-   Lancer la commande `npm run dev`
-   Créer une base de données
-   Copier le fichier `.env.example` et le renommer en `.env`
-   Modifier les variables d'environnement dans le fichier `.env`
-   Lancer la commande `php artisan migrate`
