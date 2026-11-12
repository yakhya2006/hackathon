# TP1 - Hackathon: mise en place de l'ORM (Object Relational Mapping)

## Prérequis
- PHP 8.5, Composer 2.10, Symfony CLI 5.22
- MariaDB 13.0 (installé sur mon PC à la place de MySQL)

## Installation

Le projet n'a pas encore de dépôt distant. Je récupère le dossier du projet, puis j'installe les dépendances :

```bash
cd hackaton
composer install
```

### Utilisateur de la base

Symfony ne peut pas se connecter avec `root` (erreur 1698, `root` passe par `unix_socket`). J'ai donc créé un utilisateur pour le projet :

```bash
sudo mariadb
```

```sql
CREATE USER 'hackaton'@'localhost' IDENTIFIED BY 'mot_de_passe';
GRANT ALL PRIVILEGES ON hackaton.* TO 'hackaton'@'localhost';
```

Le TP demandait la base `Hackathon` et l'utilisateur `user_hack`. J'ai utilisé `hackaton` pour les deux.

Créer un fichier `.env.local` avec :

```
DATABASE_URL="mysql://hackaton:[mot_de_passe]@127.0.0.1:3306/hackaton?serverVersion=mariadb-13.0.2&charset=utf8mb4"
```
Git ignore `.env.local`, donc le mot de passe reste sur le PC.

Symfony lit plusieurs fichiers `.env` (`.env`, `.env.local`, `.env.dev`...). Cette commande montre la valeur qu'il utilise vraiment :

```bash
php bin/console debug:dotenv DATABASE_URL
```


## Entités

| Entité       | Attributs principaux         |
| ------------ | ---------------------------- |
| Hackathon    | dateHeureDebut, dateHeureFin |
| Organisateur | nom, status                  |

Pour l'instant j'ai créé ces deux entités. Il reste les autres entités du diagramme de classes (Equipe, Participant, Projet...).

## Fixtures 

Le jeu d'essai est dans `src/DataFixtures/AppFixtures.php`. Il crée 5 hackathons et 5 organisateurs. Pour chaque objet je fais `new`, j'appelle les setters puis `$manager->persist()`. À la fin, `$manager->flush()` envoie les `INSERT` en base.

Installer le bundle des fixtures :

```bash
composer require --dev doctrine/doctrine-fixtures-bundle
```

## Base de données et jeux d'essai (fixtures)
Générer et appliquer les migrations et charger le jeu d'essai :

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

pour installer doctrine :
```shell
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
```

création de la base de données :
```shell
php bin/console doctrine:database:create
```

création d'entité (relancer la commande sur une entité existante pour lui ajouter des attributs) :
```shell
php bin/console make:entity
```

création de fichier de migration :
```shell
php bin/console make:migration
```

migration :
```shell
php bin/console doctrine:migrations:migrate
```

voir quelles migrations sont passées :
```shell
php bin/console doctrine:migrations:status
```

vérifier que les entités et les tables correspondent :
```shell
php bin/console doctrine:schema:validate
```

charger les fixtures (la commande vide les tables avant, `--append` ajoute sans vider) :
```bash
php bin/console doctrine:fixtures:load
```

## Test d'interrogation

Requête :

```bash
php bin/console dbal:run-sql "SELECT * FROM hackathon"
```

Résultat (extrait) :

```
 ---- --------------------- --------------------- 
  id   date_heure_debut      date_heure_fin       
 ---- --------------------- --------------------- 
  1    2026-11-04 10:41:45   2026-11-06 10:41:45  
  2    2026-11-04 10:41:45   2026-11-06 10:41:45  
  3    2026-11-04 10:41:45   2026-11-06 10:41:45  
  4    2026-11-04 10:41:45   2026-11-06 10:41:45  
  5    2026-11-04 10:41:45   2026-11-06 10:41:45  
 ---- --------------------- --------------------- 
```

Pour une requête qui ne commence pas par `SELECT`, il faut ajouter `--force-fetch`, sinon on voit seulement "0 rows affected" :

```bash
php bin/console dbal:run-sql --force-fetch "SHOW TABLES"
```

## Difficultés rencontrées 
- `Access denied for user 'root'@'localhost'` : j'ai créé l'utilisateur `hackaton` au lieu d'utiliser `root`.
- Sur mon PC, la migration plantait sur `DROP TABLE hackaton` (table renommée en `hackathon` au lycée). J'ai mis `DROP TABLE IF EXISTS`.
- DBeaver était connecté au port 3307 (MySQL du Docker de MiniStage) alors que Symfony utilise le 3306.
