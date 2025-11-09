# Zootopia - Gestion de Parc Animalier (Projet Scolaire)

Zootopia est une application web développée avec Symfony dans le cadre d'un projet scolaire. L'objectif est de créer un système de gestion pour un parc animalier, permettant de superviser les espaces, les enclos et les animaux. Ce projet a pour but de mettre en pratique les concepts fondamentaux du framework Symfony, notamment l'architecture MVC, l'ORM Doctrine, la gestion des formulaires et les contraintes de validation.

## ✨ Technologies utilisées

*   **Langage** : PHP 8.2
*   **Framework** : Symfony 6.4
*   **Base de données** : MySQL / MariaDB (via Doctrine ORM)
*   **Moteur de template** : Twig
*   **Gestion des dépendances** : Composer
*   **Styling** : Bootstrap (via Symfony UX)

## 🚀 Fonctionnalités principales

L'application offre une gestion complète et intuitive des entités qui composent le zoo :

*   **Gestion des Espaces** : Créez, consultez, modifiez et supprimez les grandes zones thématiques du zoo (ex: "Savane", "Aquarium").
*   **Gestion des Enclos** : Administrez les enclos au sein de chaque espace, en précisant leur superficie et leur capacité d'accueil.
*   **Gestion des Animaux** : Tenez un registre détaillé pour chaque animal, incluant son numéro d'identification, son espèce, son état de santé, et son assignation à un enclos.
*   **Vues hiérarchiques et immersives** :
    *   Naviguez d'un espace à la liste des enclos qu'il contient.
    *   Explorez un enclos pour voir la liste complète des animaux qui y résident.
*   **Logique métier intelligente** : Le système n'est pas seulement un catalogue, il applique des règles de gestion pour assurer le bien-être des animaux et la cohérence des données.

## ⚙️ Contraintes fonctionnelles et techniques

Pour garantir une gestion réaliste et fiable, le projet intègre plusieurs règles métier directement dans le code :

*   **Capacité maximale des enclos** : Le système protège contre la surpopulation. Il est impossible d'ajouter un animal à un enclos si sa capacité maximale est déjà atteinte. Cette logique est implémentée à deux niveaux :
    1.  **Niveau Entité** : Une exception est levée pour bloquer l'opération au plus bas niveau.
    2.  **Niveau Contrôleur** : Une vérification est effectuée en amont pour fournir un retour clair et immédiat à l'utilisateur, sans générer d'erreur technique.

*   **Gestion automatisée de la quarantaine** : La santé de vos animaux est primordiale.
    *   Lorsqu'un animal est placé en quarantaine, l'enclos qui l'héberge est automatiquement marqué comme étant "en quarantaine" pour alerter le personnel.
    *   L'enclos ne retrouve son statut normal que lorsque plus aucun animal à l'intérieur n'est en quarantaine.

## 🛡️ Exemples de contraintes de validation expliquées

Pour garantir la qualité et l'intégrité des données saisies par les utilisateurs, le projet utilise le composant **Validator** de Symfony. Voici des exemples concrets de contraintes implémentées, avec une explication de leur rôle.

### Entité `Animaux`

La validation des animaux assure que chaque information est cohérente, unique et logique.

```php
// src/Entity/Animaux.php

class Animaux
{
    /**
     * @Pourquoi: Chaque animal doit avoir un identifiant unique et standardisé pour un suivi rigoureux.
     * Le format à 14 chiffres est une norme interne au zoo.
     * @Contrainte: `Regex` vérifie que la valeur est une chaîne composée exclusivement de 14 chiffres.
     */
    #[Assert\Regex(
        pattern: '/^\d{14}$/',
        message: 'Le numéro d\'identification doit contenir exactement 14 chiffres.'
    )]
    private ?string $Numero_identification = null;

    /**
     * @Pourquoi: C'est une règle de bon sens pour éviter les erreurs de saisie.
     * Un animal ne peut pas être arrivé au zoo avant même d'être né.
     * @Contrainte: `LessThanOrEqual` compare la date de naissance avec la date d'arrivée.
     */
    #[Assert\LessThanOrEqual(
        propertyPath: 'Date_Arrivee_au_zoo',
        message: 'La date de naissance doit être antérieure ou égale à la date d\'arrivée au zoo.'
    )]
    private ?\DateTime $Date_naissance = null;

    /**
     * @Pourquoi: Assure la cohérence chronologique du parcours d'un animal.
     * Un animal ne peut pas quitter le zoo avant d'y être arrivé.
     * @Contrainte: `GreaterThanOrEqual` s'assure que la date de départ est postérieure ou égale à celle d'arrivée.
     */
    #[Assert\GreaterThanOrEqual(
        propertyPath: 'Date_Arrivee_au_zoo',
        message: 'La date de départ du zoo doit être postérieure ou égale à la date d\'arrivée au zoo.'
    )]
    private ?\DateTime $Date_de_Depart_du_zoo = null;
}
```

### Entité `Enclos`

Les contraintes sur les enclos garantissent que leurs caractéristiques physiques sont valides et que les informations essentielles sont présentes.

```php
// src/Entity/Enclos.php

class Enclos
{
    /**
     * @Pourquoi: Chaque enclos doit pouvoir être identifié par un nom. Un nom vide n'est pas acceptable.
     * @Contrainte: `NotBlank` s'assure que le champ n'est pas vide.
     */
    #[Assert\NotBlank(message: 'Le nom de l\'enclos ne peut pas être vide.')]
    private ?string $Nom = null;

    /**
     * @Pourquoi: Une superficie ou une capacité ne peuvent pas être négatives ou nulles.
     * Ce sont des mesures physiques qui doivent avoir une valeur positive.
     * @Contraintes: `Positive` et `NotNull` garantissent que la valeur est un nombre strictement supérieur à zéro.
     */
    #[Assert\Positive(message: 'La superficie doit être un nombre positif.')]
    #[Assert\NotNull(message: 'La superficie ne peut pas être nulle.')]
    private ?float $Superficie = null;

    #[Assert\Positive(message: 'La capacité maximale doit être un nombre positif.')]
    #[Assert\NotNull(message: 'La capacité maximale ne peut pas être nulle.')]
    private ?int $CapaciteMax = null;
}
```

### Entité `Espace`

Ici, une validation plus complexe est nécessaire pour gérer la dépendance entre deux champs de date.

```php
// src/Entity/Espace.php

class Espace
{
    /**
     * @Pourquoi: Pour les règles métier qui dépendent de plusieurs champs, une simple annotation ne suffit pas.
     * Ici, nous voulons nous assurer que si une date de fermeture est spécifiée, la date d'ouverture doit obligatoirement exister.
     * @Contrainte: `Callback` permet de définir une méthode de validation personnalisée au sein de l'entité.
     * La logique vérifie la condition et, si elle n'est pas respectée, crée une erreur de validation ciblée sur le champ `Date_fermeture`.
     */
    #[Assert\Callback]
    public function validationDates(ExecutionContextInterface $context): void
    {
        if ($this->Date_fermeture !== null && $this->Date_ouverture === null) {
            $context->buildViolation('Veuillez renseigner la date d\'ouverture avant de définir une date de fermeture.')
                ->atPath('Date_fermeture')
                ->addViolation();
        }
    }
}
```

## 🛠️ Installation et exécution

Suivez ces étapes pour lancer le projet sur votre machine locale.

1.  **Cloner le dépôt**
    ```bash
    git clone https://github.com/votre-utilisateur/zootopia.git
    cd zootopia
    ```

2.  **Installer les dépendances PHP**
    ```bash
    composer install
    ```

3.  **Configurer la base de données**
    *   Copiez le fichier `.env` vers `.env.local`.
    *   Modifiez la variable `DATABASE_URL` dans `.env.local` avec vos identifiants de base de données (MySQL/MariaDB).
    ```
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8.0.32&charset=utf8mb4"
    ```

4.  **Créer la base de données et appliquer les migrations**
    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

5.  **Lancer le serveur**
    ```bash
    symfony server:start
    ```
    L'application sera accessible à l'adresse `https://127.0.0.1:8000`.

## 📂 Structure du projet

Le projet suit l'architecture standard de Symfony :

-   `src/` : Contient le code PHP de l'application (Entités, Contrôleurs, Repositories, etc.).
-   `templates/` : Contient les fichiers de template Twig pour le rendu des pages.
-   `public/` : C'est le point d'entrée de l'application (`index.php`) et le répertoire où sont stockés les assets (CSS, JS, images).
-   `config/` : Contient les fichiers de configuration de l'application (routes, services, packages).
-   `migrations/` : Contient les migrations de la base de données générées par Doctrine.

---


## 👨‍💻 Auteur

Projet réalisé par **Steeven** – étudiant en développement web à l’EPSI Nantes.
