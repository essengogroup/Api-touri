# About Api-touri

Api pour gérer les réservations des touristes des utilisateurs de l'application touri-touri.

# TODO

- sur l'interface de reservation d'un site, demander à l'utilisateur de choisir une date de visite, si la date est déjà
  prise ou n'est pas proposé, lui proposer une autre saisir une autre date

# Installation

## Prérequis

- PHP 8.1^
- Composer
- MySQL 8.0^
- Node 14.17.6^
- NPM 6.14.15^

## Installation

- Cloner le projet
- Se placer dans le dossier du projet
- Lancer la commande `composer install`
- Lancer la commande `npm install`
- Lancer la commande `npm run build`
- Copier le fichier `.env.example` et le renommer en `.env`
- Modifier les variables d'environnement dans le fichier `.env`
- Lancer la commande `php artisan migrate` pour créer les tables dans la base de données

# structure de la Base de données

### users

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

### departements

    -   id | int
    -   name | string
    -   description | text?
    -   image_path | string?
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### sites

    -   id | int
    -   departement_id | int (foreign key)
    -   name | string
    -   description | text?
    -   price | int
    -   latitude | decimal
    -   longitude | decimal
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### medias

    -   id | int
    -   site_id | int (foreign key)
    -   name | string?
    -   path | string
    -   type | string (image, video)
    -   is_main | boolean (default: false)
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### sites_dates *

corrrespond aux dates disponibles pour les sites

    -   id | int
    -   site_id | int (foreign key)
    -   date_ | date
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### activites

corrrespond aux activités à faire sur un site

    -   id | int
    -   name | string
    -   description | text?
    -   image_path | string?
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### media_activites *

    -   id | int
    -   activite_id | int (foreign key)
    -   name | string?
    -   path | string
    -   type | string (image, video)
    -   is_main | boolean (default: false)
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### activites_sites  `pivot` *

corrrespond aux activités disponibles sur un site

    -   id | int
    -   site_id | int (foreign key)
    -   activite_id | int (foreign key)
    -   created_at | datetime (default: now)
    -   updated_at | datetime (default: now)

### reservation_sites

correspond aux réservations des sites

    - id | int
    - site_id | int (foreign key)
    - user_id | int (foreign key)
    - date_reservation | date
    - price | float
    - nb_personnes | int (default: 1)
    - is_paid | boolean (default: false)
    - status (pending, accepted, refused,canceled) (default: pending)
    - commentaire | text?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)
    - deleted_at | datetime?

### reservations_activites `pivot` *

    - id | int
    - reservation_site_id | int (foreign key)
    - activite_id | int (foreign key)

### events *

correspond aux événements organisés par les sites

    - id | int
    - title | string
    - description | text
    - image_path | string
    - date_event | date
    - place | int?
    - price | float
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### reservation_events *

correspond aux réservations des événements

    - id | int
    - user_id | int (foreign key)
    - event_id | int (foreign key)
    - price | float
    - nb_personnes | int (default: 1)
    - is_paid | boolean (default: false)
    - status (pending, accepted, refused,canceled) (default: pending)
    - commentaire | text?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)
    - deleted_at | datetime?

### trophets *

    - id | int
    - name | string
    - description | text?
    - image_path | string?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### users_trophets `pivot` *

    - id | int
    - user_id | int (foreign key)
    - trophet_id | int (foreign key)

# table à ajouter

### commentaires

    - id | int
    - user_id | int (foreign key)
    - site_id | int (foreign key)
    - commentaire | text
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### likes

        - id | int
        - user_id | int (foreign key)
        - site_id | int (foreign key)
        - created_at | datetime (default: now)
        - updated_at | datetime (default: now)

### partages

        - id | int
        - user_id | int (foreign key)
        - site_id | int (foreign key)
        - created_at | datetime (default: now)
        - updated_at | datetime (default: now)

### raitings

        - id | int
        - user_id | int (foreign key)
        - site_id | int (foreign key)
        - raiting | int
        - created_at | datetime (default: now)
        - updated_at | datetime (default: now)

### transports

    - id | int
    - name | string
    - description | text?
    - image_path | string?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### hebergements

    - id | int
    - name | string
    - description | text?
    - image_path | string?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### restaurants

    - id | int
    - name | string
    - description | text?
    - image_path | string?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### assurances

    - id | int
    - name | string
    - description | text?
    - image_path | string?
    - created_at | datetime (default: now)
    - updated_at | datetime (default: now)

### guides

        - id | int
        - name | string
        - description | text?
        - image_path | string?
        - created_at | datetime (default: now)
        - updated_at | datetime (default: now)


