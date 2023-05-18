## About Api-touri

Api pour gérer les réservations des touristes des utilisateurs de l'application touri-touri.

## Mise en place du projet

### Prérequis

- PHP 8.1^
- Composer 2.1.9^
- MySQL 8.0^
- Node 14.17.6^
- NPM 6.14.15^

### Installation

- Cloner le projet sur votre machine locale `git clone https://github.com/essengogroup/Api-touri.git`.
- Se placer dans le dossier du projet `cd Api-touri`.
- Lancer la commande `composer install` pour installer les dépendances PHP.
- Lancer la commande `npm install`.
- Lancer la commande `npm run build`.
- Copier le fichier `.env.example` et le renommer en `.env`.
- Modifier les variables d'environnement dans le fichier `.env` (base de données, mail, etc.) selon votre configuration.
- Lancer la commande `php artisan migrate` pour créer les tables dans la base de données.
- Lancer la commande `php artisan db:seed` pour remplir les tables avec des données de test.

## TODO

### ux
- sur l'interface de reservation d'un site, demander à l'utilisateur de choisir une date de visite, si la date est déjà
  prise ou n'est pas proposé, lui proposer une autre saisir une autre date

### backend
- renseigner l'ensemble des routes dans api.php
- ecrire les seeder pour l'ensemble des models
- test l'ensemble des request api

## structure de la Base de données

### User

    -   id | int
    -   full_name | string
    -   email | string (unique)
    -   phone | string?
    -   profile_picture | string?
    -   address | string?
    -   email_verified_at | datetime?
    -   password | string
    -   remember_token | string?
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### Departement

    -   id | int
    -   name | string
    -   description | text?
    -   image_path | string?
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### Site

on peut gagner un trophet si on visite tous les sites d'un departement

    -   id | int
    -   departement_id | int (foreign key)
    -   name | string
    -   description | text?
    -   address | string?
    -   price | int
    -   is_date_required | boolean (default: false)
    -   is_active | boolean (default: true)
    -   latitude | decimal
    -   longitude | decimal
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### Media

    -   id | int
    -   site_id | int (foreign key)
    -   name | string?
    -   path | string
    -   type | string (image, video)
    -   is_main | boolean (default: false)
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### SiteDate

corrrespond aux dates disponibles pour les sites

    -   id | int
    -   site_id | int (foreign key)
    -   date_visite | date
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### Activite

corrrespond aux activités à faire sur un site, on peut gagner un trophet si on fait toutes les activités d'un site

    -   id | int
    -   name | string
    -   description | text?
    -   image_path | string?
    -   price | float
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### MediaActivite

    -   id | int
    -   activite_id | int (foreign key)
    -   name | string?
    -   path | string
    -   type | string (image, video)
    -   is_main | boolean (default: false)
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### activites_sites `pivot`

corrrespond aux activités disponibles sur un site

    -   id | int
    -   site_id | int (foreign key)
    -   activite_id | int (foreign key)
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### ReservationSite

correspond aux réservations des sites

    - id | int
    - site_id | int (foreign key)
    - user_id | int (foreign key)
    - date_reservation | date
    - price | float
    - nb_personnes | int (default: 1)
    - is_paid | boolean (default: false)
    - status | (pending, accepted, refused,canceled,paid) (default: pending)
    - commentaire | text?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)
    - deleted_at | datetime?

### reservations_activites `pivot`

    - id | int
    - reservation_site_id | int (foreign key)
    - activite_id | int (foreign key)
    - price | float
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### EventTouri

correspond aux événements organisés par les sites, on peut poster des événements sur l'event

    - id | int
    - name | string
    - description | text?
    - image_path | string
    - date_event | date
    - place | int?
    - price | float
    - status | (active, inactive) (default: active)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### ReservationEvent

correspond aux réservations des événements

    - id | int
    - user_id | int (foreign key)
    - event_id | int (foreign key)
    - nb_persons | int (default: 1)
    - status (pending, accepted, refused,canceled,paid) (default: pending)
    - commentaire | text?
    - price | float
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)
    - deleted_at | datetime?

### Trophet

    - id | int
    - name | string
    - description | text?
    - image_path | string?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### users_trophets `pivot`

    - id | int
    - user_id | int (foreign key)
    - trophet_id | int (foreign key)

### commentaires (morph)

    - id | int
    - user_id | int (foreign key)
    - comment | text
    - commentable_id | int (foreign key)
    - commentable_type | string (Site, Activite, EventTouri)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### likes (morph)

    - id | int
    - user_id | int (foreign key)
    - site_id | int (foreign key)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### Share (morph)

    - id | int
    - user_id | int (foreign key)
    - shareable_id | int (foreign key)
    - shareable_type | string (Site, Activite, EventTouri)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### Raiting (morph)

    - id | int
    - user_id | int (foreign key)
    - raitable_id | int (foreign key)
    - raitable_type | string (Site, Activite, EventTouri)
    - value | int (default: 0)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### Transport

    - id | int
    - name | string
    - description | text?
    - image_path | string?
    - price | float
    - is_available | boolean (default: true)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### transports_sites `pivot`

    - id | int
    - site_id | int (foreign key)
    - transport_id | int (foreign key)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### hebergements

    - id | int
    - name | string
    - description | text?
    - image_path | string?
    - price | float
    - address | string?
    - phone | string?
    - latitude | float?
    - longitude | float?
    - is_available | boolean (default: true)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### hebergements_sites `pivot`

    - id | int
    - site_id | int (foreign key)
    - hebergement_id | int (foreign key)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### Restaurant

    - id | int
    - name | string
    - description | text?
    - image_path | string?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### restaurants_sites `pivot`

    - id | int
    - site_id | int (foreign key)
    - restaurant_id | int (foreign key)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### Assurance

    - id | int
    - name | string
    - description | text?
    - image_path | string?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### assurances_sites `pivot`

    - id | int
    - site_id | int (foreign key)
    - assurance_id | int (foreign key)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### Guide

    - id | int
    - name | string
    - description | text?
    - image_path | string?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### guides_sites `pivot`

    - id | int
    - site_id | int (foreign key)
    - guide_id | int (foreign key)
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)
