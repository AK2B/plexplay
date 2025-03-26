# Plexiplay WordPress Docker

Ce projet contient une configuration Docker pour le site Plexiplay, basé sur WordPress avec WooCommerce.

## Structure du projet

- `docker-compose.yml` : Configuration des services Docker (WordPress, MySQL, phpMyAdmin)
- `Dockerfile` : Configuration de l'image Docker pour WordPress
- `.env` : Variables d'environnement pour la configuration
- `plexiplay/www/` : Fichiers WordPress
- `qh1mtxit_plexiplay_fr.sql` : Dump de la base de données

## Prérequis

- Docker
- Docker Compose

## Installation

1. Clonez ce dépôt
2. Lancez les conteneurs avec la commande suivante :

```bash
docker-compose up -d
```

3. Accédez au site WordPress à l'adresse : http://localhost:8080
4. Accédez à phpMyAdmin à l'adresse : http://localhost:8081

## Informations de connexion

### WordPress

- URL d'administration : http://localhost:8080/wp-admin

### Base de données

- Hôte : db
- Nom de la base de données : qh1mtxit_plexiplay_fr
- Utilisateur : qh1mtxit_plexip
- Mot de passe : Voir fichier .env

### phpMyAdmin

- URL : http://localhost:8081
- Serveur : db
- Utilisateur : root
- Mot de passe : Voir MYSQL_ROOT_PASSWORD dans le fichier .env

## Sauvegarde et restauration

### Sauvegarde

Pour sauvegarder la base de données :

```bash
docker-compose exec db mysqldump -u root -p qh1mtxit_plexiplay_fr > backup.sql
```

### Restauration

Pour restaurer la base de données :

```bash
docker-compose exec -T db mysql -u root -p qh1mtxit_plexiplay_fr < backup.sql
```

## Plugins installés

- WooCommerce
- Advanced Custom Fields
- Contact Form 7
- Yoast SEO (WordPress SEO)
- Revolution Slider
- Visual Composer (JS Composer)

## Thème

Le site utilise le thème Oxygen.