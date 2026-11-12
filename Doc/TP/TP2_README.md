# TP2 - Application Web : Response HTTP en mode Client/Serveur

## Objectif

Créer une route qui affiche tous les enregistrements d'une entité, en HTML (version 1) puis en JSON (version 2). J'ai choisi l'entité `Organisateur`.

## Prérequis

Vérifier que PHP a tout ce qu'il faut pour Symfony :

```bash
symfony check:requirements
```

Chez moi il manquait `iconv` (obligatoire) et `intl` (conseillé). Les deux extensions étaient installées mais commentées dans `/etc/php/php.ini` :

```bash
sudo sed -i -E 's/^;(extension=(iconv|intl))$/\1/' /etc/php/php.ini
php -m | grep -E '^(iconv|intl)$'
```

Installer Twig pour les pages HTML et le Serializer pour le JSON :

```bash
composer require symfony/twig-bundle symfony/serializer-pack
```

## Commandes utilisées

Créer le contrôleur et son template :

```bash
php bin/console make:controller OrganisateurController
```

La commande crée `src/Controller/OrganisateurController.php` et `templates/organisateur/index.html.twig`. Si on la relance, elle refuse parce que le fichier existe déjà.

Lister les routes du projet :

```bash
php bin/console debug:router
```

Lancer le serveur (il affiche l'adresse et le port dans le terminal) :

```bash
symfony serve
```

L'adresse `/` affiche la page "Welcome to Symfony" parce que le projet n'a pas de route pour `/`. Il faut ajouter `/organisateur` à la fin.

## Version 1 : HTML

Route : `/organisateur`

Le contrôleur reçoit `OrganisateurRepository`, récupère tous les organisateurs avec `findAll()` et les envoie au template :

```php
#[Route('/organisateur', name: 'app_organisateur')]
public function index(OrganisateurRepository $organisateurRepository): Response
{
    $organisateurs = $organisateurRepository->findAll();
    return $this->render('organisateur/index.html.twig', [
        'organisateurs' => $organisateurs,
    ]);
}
```

Dans `index.html.twig`, `{% for organisateur in organisateurs %}` crée une ligne de tableau par organisateur. `{{ organisateur.nom }}` affiche le nom (Twig appelle `getNom()`).

Pour voir la requête et la réponse : F12 dans le navigateur, onglet Réseau, puis recharger la page. On voit `GET /organisateur`, le code `200` et `Content-Type: text/html`.

## Version 2 : JSON

Pas encore faite.

## Difficultés rencontrées
- `symfony check:requirements` était en erreur à cause d'`iconv`.
- J'ouvrais `http://127.0.0.1:34445` sans `/organisateur`, donc je tombais sur la page Welcome.
