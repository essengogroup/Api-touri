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

### structure de la base de donné

> users

-   id
-   full_name
-   phone
-   profile_picture
-   email
-   address?
-   password
-   created_at
-   updated_at

> departements

-   id
-   name
-   description?
-   image_path?
-   created_at
-   updated_at

> sites (= parcours qu'un utilisateur reserve pour sa visite)

-   id
-   departement_id
-   name
-   description
-   price
-   created_at
-   updated_at

> medias (= images et videos des sites)

-   id
-   site_id
-   image_path
-   default (0 ou 1)
-   created_at
-   updated_at

> sites_dates (= dates disponibles pour les sites)

-   id
-   site_id
-   date
-   duration
-   created_at
-   updated_at

> activites (= activités à faire sur un site)

-   id
-   site_id
-   name
-   description
-   image_path?
-   created_at
-   updated_at

> activites_sites (= liste des activités liées des sites avec des activités par defaut et des activités personnalisées)

-   id
-   site_id
-   activite_id
-   type (default, custom)
-   price?
-   created_at
-   updated_at

> reservations

-   id
-   user_id
-   site_id
-   date_id
-   price
-   nb_personnes
-   details?
-   created_at
-   updated_at

> reservations_activites

-   id
-   reservation_id
-   activite_id
-   created_at
-   updated_at

> events (= événements organisés par les sites)

-   id
-   title
-   description
-   image_path?
-   limit_date_reservation
-   limit_date_cancel
-   created_at
-   updated_at

> places_events (= prix des événements organisés par les sites)

-   id
-   event_id
-   price
-   title
-   created_at
-   updated_at

> reservations_events

-   id
-   user_id
-   place_event_id
-   nb_personnes
-   price
-   status (pending, paid, canceled)
-   created_at
-   updated_at
