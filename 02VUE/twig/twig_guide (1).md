# 🧵 Guide de démarrage avec Twig

Twig est le moteur de templates utilisé par Symfony. Il permet de générer du HTML de manière dynamique, tout en restant clair, sécurisé et maintenable.

---

## 📦 Installation

Twig est installé automatiquement avec Symfony Standard Edition.

Sinon, on peut l’ajouter via Composer :

```bash
composer require twig
```

---

## 🔤 Syntaxe de base

### 🔸 Afficher une variable

```twig
{{ variable }}
```

Exemple :
```twig
<p>{{ user.name }}</p>
```

---

### 🔸 Structures de contrôle

#### 🔁 Boucle `for`

```twig
{% for item in items %}
    {{ item }}
{% endfor %}
```

Avec index :
```twig
{% for item in items %}
    {{ loop.index }} - {{ item.name }}
{% endfor %}
```

#### ❓ Condition `if`

```twig
{% if user.isAdmin %}
    <p>Bienvenue admin</p>
{% elseif user.isEditor %}
    <p>Bienvenue éditeur</p>
{% else %}
    <p>Bienvenue invité</p>
{% endif %}
```

---

## 🧰 Filtres utiles

Twig permet de modifier l'affichage des variables avec des **filtres** :

```twig
{{ name|upper }}         {# MAJUSCULES #}
{{ message|length }}     {# Longueur d'une chaîne ou tableau #}
{{ date|date("d/m/Y") }} {# Formatage de date #}
```

---

## 📁 Inclusion de templates

Twig permet de **réutiliser** des blocs avec `include` :

```twig
{% include 'partials/_navbar.html.twig' %}
```

---

## 🧩 Blocs et héritage

Twig supporte l’héritage de templates comme en POO :

### base.html.twig

```twig
<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}Mon Site{% endblock %}</title>
</head>
<body>
    {% block body %}{% endblock %}
</body>
</html>
```

### page.html.twig

```twig
{% extends 'base.html.twig' %}

{% block title %}Page spécifique{% endblock %}

{% block body %}
    <h1>Contenu de la page</h1>
{% endblock %}
```

---



## 👤 Utilisateur connecté et la variable globale `app`

Symfony injecte une variable globale `app` dans tous les templates Twig.

### Exemple : afficher l'utilisateur connecté

```twig
{% if app.user %}
    <p>Connecté en tant que {{ app.user.email }}</p>
{% else %}
    <p>Vous n'êtes pas connecté.</p>
{% endif %}
```

### Vérifier le rôle d'un utilisateur

```twig
{% if is_granted('ROLE_ADMIN') %}
    <p>Zone admin</p>
{% endif %}
```

### Autres données disponibles via `app`

- `app.user` : l'utilisateur connecté (ou `null`)
- `app.request` : l'objet Request actuel
- `app.session` : la session
- `app.environment` : l'environnement courant (`dev`, `prod`, etc.)

---

## 🧠 Bon à savoir

- `app.user` est une instance de votre entité `User`.
- Vous pouvez accéder aux méthodes comme `app.user.getNom()` ou `app.user.nom`.

---


## 🔐 Sécurité automatique

Twig **échappe automatiquement** les variables pour éviter les failles XSS. Pour afficher du HTML brut :

```twig
{{ variable|raw }}
```

⚠️ À utiliser avec précaution !

---

## 🔍 Débogage

Pour afficher toutes les variables disponibles :

```twig
{{ dump() }}         {# équivalent à var_dump #}
{{ dump(variable) }}
```

⚠️ Nécessite `symfony/debug-bundle`.

---

## ✅ Bonnes pratiques

- N’ajoutez **aucune logique métier** dans les templates.
- Utilisez les **filtres** Twig au lieu de PHP brut.
- **Préférez l’héritage** plutôt que copier-coller du HTML.

---

## 🧪 Ressources utiles

- Documentation officielle : [https://twig.symfony.com/doc/](https://twig.symfony.com/doc/)
- Filtres Twig : [https://twig.symfony.com/doc/3.x/filters/index.html](https://twig.symfony.com/doc/3.x/filters/index.html)
- Fonctions Twig : [https://twig.symfony.com/doc/3.x/functions/index.html](https://twig.symfony.com/doc/3.x/functions/index.html)

---


