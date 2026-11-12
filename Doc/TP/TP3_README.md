# TP3 - Mise en place des relations entre les entités

## Objectif

Ajouter dans les entités les relations du diagramme de classes (partie 1), puis adapter les fixtures pour que les objets soient reliés entre eux (partie 2).
## Entités

`Hackathon`, `Organisateur` et `Projet` existaient déjà. J'ai créé `Participant`, `Inscription` et `Equipe` pour ce TP.

## Créer une relation

Je relance `make:entity` sur une entité qui existe déjà, et je choisis le type `relation` :

```bash
php bin/console make:entity Hackathon
```

Exemple pour la relation Hackathon - Organisateur :

| Question | Réponse |
|---|---|
| `New property name` | `organisateur` |
| `Field type` | `relation` |
| `What class should this entity be related to?` | `Organisateur` |
| `Relation type?` | `ManyToOne` |
| `Is the Hackathon.organisateur property allowed to be null` | `no` |
| `Do you want to add a new property to Organisateur` | `yes` |
| `New field name inside Organisateur [hackathons]` | Entrée (je garde `hackathons`) |
| `orphanRemoval` | `no` |

Ensuite je mets la base à jour :

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:validate
```

## Ce que j'ai retenu

- L'attribut porte le nom de l'entité d'en face, sans `_id`. Il contient un objet. Doctrine crée lui-même la colonne `organisateur_id` en base.
- Pour savoir où mettre un `ManyToOne`, je lis la phrase depuis l'entité où je lance la commande : "Many hackathons To One organisateur". Si la phrase est vraie, je suis dans la bonne entité.
- `OneToMany` depuis l'autre entité donne exactement le même résultat. Je l'ai utilisé pour Participant - Inscription.
- Pour `null`, je regarde le chiffre collé à l'entité visée : `1` donne `no`, `0..1` donne `yes`.
- L'attribut inverse (`hackathons`, `projets`...) existe seulement en PHP, il ne crée pas de colonne. Il permet d'écrire `$organisateur->getHackathons()`.
- Le losange noir est une composition : la partie ne peut pas exister sans le tout. J'ai mis `orphanRemoval` à `yes` pour Hackathon - Inscription. La commande ne pose pas cette question quand la relation peut être vide.
- Une relation `ManyToMany` aurait créé une table de liaison. Je n'en ai pas dans ce diagramme.

## Difficultés rencontrées

- J'ai d'abord appelé l'attribut `organisateur_id`. Doctrine aurait créé une colonne `organisateur_id_id`. J'ai fait la même erreur avec `projet_id` dans `Equipe`, corrigée à la main dans `Equipe.php` et `Projet.php`.
- La migration plantait avec l'erreur `1452 Cannot add or update a child row` : les 5 hackathons déjà en base n'avaient pas d'organisateur. Comme c'était des données de test, j'ai recréé la base vide (`doctrine:database:drop --force`, `doctrine:database:create`, `doctrine:migrations:migrate`).

