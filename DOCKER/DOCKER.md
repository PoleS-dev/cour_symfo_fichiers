# 🐳 Tutoriel complet : Utiliser Docker avec Symfony + Nginx + MySQL + phpMyAdmin

Ce guide te montre comment configurer un environnement de développement Symfony complet avec **Docker**, **Nginx**, **MySQL** et **phpMyAdmin**. Idéal pour débuter ou structurer un projet proprement sans dépendre de ton système local.

---

## 🧾 Pré-requis

- Docker installé : [https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)
- Docker Compose (inclus avec Docker Desktop)

---

## 🗂 Arborescence du projet

Voici la structure finale que tu auras :

```
mon-projet/
│
├── docker/
│   ├── nginx/
│   │   └── default.conf
│   ├── php/
│   │   └── Dockerfile
│
├── docker-compose.yml
├── .env
├── symfony/       # Projet Symfony ici
```

---

## 🛠 Étape 1 : Créer le fichier `docker-compose.yml`

```yaml
version: '3.8'

services:
  php:
    build:
      context: ./docker/php
    volumes:
      - ./symfony:/var/www/html
    working_dir: /var/www/html
    depends_on:
      - db

  nginx:
    image: nginx:latest
    ports:
      - "8080:80"
    volumes:
      - ./symfony:/var/www/html
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - php

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: symfony
      MYSQL_USER: symfony
      MYSQL_PASSWORD: symfony
    ports:
      - "3306:3306"

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    ports:
      - "8081:80"
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: root
```

---

## 🛠 Étape 2 : Dockerfile PHP (`docker/php/Dockerfile`)

```Dockerfile
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev zip \
    && docker-php-ext-install intl pdo pdo_mysql zip

    # Installer symfony-cli dans le conteneur PHP
RUN curl -sS https://get.symfony.com/cli/installer | bash \
&& mv /root/.symfony*/bin/symfony /usr/local/bin/symfony


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
```

---

## 🛠 Étape 3 : Configuration Nginx (`docker/nginx/default.conf`)

```nginx
server {
    listen 80;
    server_name localhost;

    root /var/www/html/public;

    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_pass php:9000;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

---

## 🛠 Étape 4 : Initialiser un projet Symfony

Dans le dossier `symfony/` :

```bash
composer create-project symfony/skeleton .
```

---

## ⚙️ Étape 5 : Modifier `.env` de Symfony

Dans `symfony/.env`, modifier la ligne `DATABASE_URL` :

```env
DATABASE_URL="mysql://symfony:symfony@db:3306/symfony"
```

---

## 🚀 Étape 6 : Lancer les conteneurs

À la racine du projet :

```bash
docker-compose up -d --build
```

- Symfony : [http://localhost:8080](http://localhost:8080)
- phpMyAdmin : [http://localhost:8081](http://localhost:8081)

---

## 🧪 Étape 7 : Accès à la base de données

Via phpMyAdmin :

- Hôte : `db`
- Utilisateur : `symfony`
- Mot de passe : `symfony`
- Base de données : `symfony`

---

## 🛠 Étape 8 : Lancer des commandes Symfony dans le conteneur PHP

```bash
docker-compose exec php bash
# Une fois dans le conteneur :
php bin/console make:controller
```

---

## 🔗 Ressources utiles

- Symfony & Docker : https://symfony.com/doc/current/setup/docker.html
- Docker Compose docs : https://docs.docker.com/compose/
- phpMyAdmin : https://www.phpmyadmin.net/

---
