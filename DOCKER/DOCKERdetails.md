# 🐳 Tutoriel Docker ultra détaillé pour Symfony + Nginx + MySQL + phpMyAdmin

Ce guide t’explique **pas à pas** et **ligne par ligne** comment configurer un environnement Docker pour un projet Symfony avec **Nginx comme serveur web**, **MySQL comme base de données** et **phpMyAdmin pour l’administration**.

---

## 🧠 Objectif

Tu vas construire un environnement composé de 4 services **isolés** :

1. **PHP (FPM)** : exécution du code Symfony
2. **Nginx** : serveur HTTP qui gère les requêtes web
3. **MySQL** : base de données relationnelle
4. **phpMyAdmin** : interface web pour administrer MySQL

---

## 🗂️ Structure du projet

```
mon-projet/
│
├── docker/
│   ├── nginx/            # Configuration du serveur Nginx
│   │   └── default.conf
│   ├── php/              # Configuration de l’image PHP
│   │   └── Dockerfile
│
├── docker-compose.yml    # Point d'entrée Docker
├── .env                  # Variables Symfony
├── symfony/              # Projet Symfony
```

---

## 🔍 Pourquoi `.env` est à l’extérieur du dossier `symfony/` ?

Dans l’arborescence :

```
mon-projet/
├── .env                  ← utilisé par Docker Compose
├── symfony/
│   └── .env              ← utilisé par Symfony
```

Il y a **deux fichiers `.env`** utilisés pour des buts différents.

---

### 📁 `.env` (à la racine du projet)

➡️ Utilisé par **Docker Compose**.

Ce fichier permet de **définir des variables d’environnement globales** pour tes conteneurs.

Exemple :
```env
MYSQL_ROOT_PASSWORD=root
MYSQL_DATABASE=symfony
MYSQL_USER=symfony
MYSQL_PASSWORD=symfony
```

Et dans `docker-compose.yml` :

```yaml
environment:
  MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
  MYSQL_DATABASE: ${MYSQL_DATABASE}
```

Avantages :
- Tu n’as pas à dupliquer les valeurs dans tous les fichiers.
- Tu peux faire un fichier `.env.example` pour partager la config sans secrets.

---

### 📁 `symfony/.env` (dans le projet Symfony)

➡️ Utilisé par **Symfony** via le composant `Dotenv`.

Ce fichier configure l'application elle-même :

```env
APP_ENV=dev
APP_DEBUG=1
DATABASE_URL="mysql://symfony:symfony@db:3306/symfony"
```

Ce fichier permet :
- De dire à Symfony dans quel environnement il tourne
- De connecter à la base de données
- De configurer les services (Mailer, Redis, etc.)

---

### 🔐 Bonnes pratiques

- ✅ `.env` à la racine → **Docker Compose**
- ✅ `symfony/.env` → **Symfony uniquement**
- ❌ Ne mets jamais de secrets dans `.env` versionné (utilise `.env.local` pour ça)

---

## 🔹 Étape 1 : Fichier `docker-compose.yml` (chef d’orchestre)

```yaml
version: '3.8'
```
➡️ Version du format utilisé par Docker Compose

```yaml
services:
```
➡️ Déclaration des services à lancer dans des conteneurs.

### 🔸 Service PHP

```yaml
  php:
    build:
      context: ./docker/php
```
- On **construit l’image PHP** à partir d’un `Dockerfile` situé dans `docker/php`.

```yaml
    volumes:
      - ./symfony:/var/www/html
```
- Montre le dossier local `symfony/` dans le conteneur (accès au code).

```yaml
    working_dir: /var/www/html
```
- Définit le répertoire de travail par défaut.

```yaml
    depends_on:
      - db
```
- Ce service attend que `db` (MySQL) soit lancé avant.

---

### 🔸 Service Nginx

```yaml
  nginx:
    image: nginx:latest
```
- Utilise l’image officielle de Nginx.

```yaml
    ports:
      - "8080:80"
```
- Redirige le port local `8080` vers le port `80` du conteneur (accès via http://localhost:8080)

```yaml
    volumes:
      - ./symfony:/var/www/html
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
```
- Monte le code Symfony + le fichier de configuration nginx.

```yaml
    depends_on:
      - php
```
- Démarre après le service `php`.

---

### 🔸 Service MySQL

```yaml
  db:
    image: mysql:8.0
```
- Utilise l’image officielle de MySQL version 8.

```yaml
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: symfony
      MYSQL_USER: symfony
      MYSQL_PASSWORD: symfony
```
- Initialise une base de données nommée `symfony` avec un utilisateur.

```yaml
    ports:
      - "3306:3306"
```
- Redirige le port local 3306 (utile si tu veux te connecter avec un client DB).

---

### 🔸 Service phpMyAdmin

```yaml
  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    ports:
      - "8081:80"
```
- Interface web accessible via http://localhost:8081

```yaml
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: root
```
- Se connecte automatiquement à `db` (MySQL) avec les identifiants donnés.

---

## 🛠 Étape 2 : Dockerfile PHP (`docker/php/Dockerfile`)

```Dockerfile
FROM php:8.2-fpm
```
- Image de base officielle PHP (FastCGI Process Manager)

```Dockerfile
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev zip \
    && docker-php-ext-install intl pdo pdo_mysql zip

    # Installer symfony-cli dans le conteneur PHP
RUN curl -sS https://get.symfony.com/cli/installer | bash \
&& mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

```
- Installe les extensions nécessaires pour Symfony : `intl`, `pdo_mysql`, `zip`, et symfony cli etc.

```Dockerfile
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
```
- Copie `composer` depuis une autre image officielle. Permet de gérer les dépendances PHP.

---

## 🧾 Étape 3 : Configuration Nginx (`docker/nginx/default.conf`)

```nginx
server {
    listen 80;
    server_name localhost;
    root /var/www/html/public;
```
- Définit le port d’écoute et le répertoire racine pour Symfony (`public/`).

```nginx
    location / {
        try_files $uri /index.php$is_args$args;
    }
```
- Si le fichier demandé n'existe pas, redirige vers `index.php`.

```nginx
    location ~ \.php$ {
        fastcgi_pass php:9000;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
```
- Gère l’exécution des scripts PHP avec FastCGI.

---

## 🌀 Étape 4 : Création du projet Symfony

Dans `symfony/` :
```bash
composer create-project symfony/skeleton .
```
- Initialise un projet Symfony minimaliste.

---

## ⚙️ Étape 5 : Configuration `.env` Symfony

Dans `symfony/.env` :

```env
DATABASE_URL="mysql://symfony:symfony@db:3306/symfony"
```

- Connexion à la base MySQL sur le conteneur `db` avec identifiants `symfony`.

---

## 🚀 Étape 6 : Démarrer les conteneurs

```bash
docker-compose up -d --build
```

- `-d` : mode détaché (en arrière-plan)
- `--build` : reconstruit les images si nécessaire

---

## 🌐 Accès aux services

| Service      | URL                   |
|--------------|------------------------|
| Symfony      | http://localhost:8080 |
| phpMyAdmin   | http://localhost:8081 |

---

## 🛠 Étape 7 : Utiliser Symfony dans Docker

```bash
docker-compose exec php bash
```

Puis dans le conteneur :
```bash
php bin/console make:controller
```

---

## 🧹 Étape 8 : Maintenance

| Commande                          | Fonction                             |
|----------------------------------|--------------------------------------|
| `docker-compose stop`            | Arrêter les conteneurs               |
| `docker-compose down -v`         | Supprimer les conteneurs + volumes   |
| `docker-compose restart`         | Redémarrer les services              |
| `docker-compose exec php bash`   | Entrer dans le conteneur PHP         |

---

## ✅ Résumé

Ce setup t’offre :

- Un environnement Symfony portable et isolé
- Un accès direct à la base via phpMyAdmin
- Une vraie séparation des services (Nginx, PHP, DB)

---

## 🔗 Liens utiles

- Symfony avec Docker : https://symfony.com/doc/current/setup/docker.html
- Docker Compose : https://docs.docker.com/compose/
- phpMyAdmin : https://hub.docker.com/_/phpmyadmin

---


---


---

