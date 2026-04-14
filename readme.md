# FrealanceConnect

## Prérequis

- PHP >= 8.4
- Composer
- Node.js + npm/yarn (pour Tailwind et pipeline de CSS)
- Bases de données configurée (MySQL)

## Installation et exécution

1. Cloner le dépôt

```bash
git clone https://github.com/juangomes376/FrealanceConnect FrealanceConnect
cd FrealanceConnect/web
```

2. Installer les dépendances PHP

```bash
composer install
```

3. Installer les dépendances JS (si nécessaire)

```bash
npm install
# ou yarn install
```

4. Configurer l'environnement

Copier `.env` en `.env.local` et définir :

- `APP_ENV=dev`
- `APP_SECRET=<clé-secrète>`
- `DATABASE_URL=<connexion-db>`

5. Créer la base de données et exécuter les migrations

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

6. Générer les assets (Tailwind + mapper)

```bash
php bin/console tailwind:build --env=dev
php bin/console asset-map:compile
php bin/console assets:install public --symlink
```

7. Lancer le serveur de développement

```bash
php bin/console server:run
```

Le projet sera accessible par défaut sur `http://127.0.0.1:8000`.

## Commandes utiles

- Validation de Doctrine : `php bin/console doctrine:schema:validate`
- Nettoyage du cache : `php bin/console cache:clear --env=dev`
- Création du secret : `APP_SECRET=$(openssl rand -hex 16)`

## Architecture

- `src/Controller` : routes et logique de contrôle
- `src/Entity` : entités Doctrine (User, Event, Categories, Reservation)
- `templates/` : vues Twig
- `assets/styles/app.css` : Tailwind import + configuration
- `config/packages/symfonycasts_tailwind.yaml` : configuration du bundle Tailwind

## Notes de déploiement

- En production, utiliser `APP_ENV=prod` et `APP_DEBUG=0`
- Ne pas stocker le secret dans le dépôt Git (utiliser variables d'environnement ou un vault)
- Exécuter `php bin/console tailwind:build --env=prod` avant déploiement

## Postmortem