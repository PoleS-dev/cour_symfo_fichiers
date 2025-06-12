# 🧩 Comprendre `base.html.twig` dans Symfony

Le fichier `base.html.twig` sert de **template principal** (ou layout) à partir duquel les autres vues héritent. Il permet de centraliser l’en-tête HTML, les scripts, les feuilles de style, les balises communes (menu, footer...).

---

## 🧱 Structure typique d’un `base.html.twig`

```twig
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{% block title %}Titre par défaut{% endblock %}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {# Feuilles de style #}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {% block stylesheets %}{% endblock %}
</head>
<body>
    <header>
        {% block header %}
            <h1>Mon site Symfony</h1>
        {% endblock %}
    </header>

    <main>
        {% block body %}{% endblock %}
    </main>

    <footer>
        {% block footer %}
            <p>&copy; {{ "now"|date("Y") }} MonSite</p>
        {% endblock %}
    </footer>

    {# Scripts JS #}
    <script src="{{ asset('js/app.js') }}"></script>
    {% block javascripts %}{% endblock %}
</body>
</html>
```

---

## 🔁 Utilisation dans d'autres templates

### Exemple : `home.html.twig`

```twig
{% extends 'base.html.twig' %}

{% block title %}Accueil{% endblock %}

{% block body %}
    <h2>Bienvenue sur la page d’accueil</h2>
{% endblock %}
```

---

## 🧩 Blocs disponibles à définir

| Bloc Twig       | Utilité                                            |
|-----------------|----------------------------------------------------|
| `title`         | Le titre affiché dans l’onglet du navigateur       |
| `stylesheets`   | Ajouter des CSS supplémentaires                    |
| `header`        | Contenu de l’en-tête (navigation, logo...)         |
| `body`          | Contenu principal de la page                       |
| `footer`        | Pied de page (copyright, liens...)                 |
| `javascripts`   | Scripts JS spécifiques à une page                  |

---

## 🛠 Bonnes pratiques

- Ne jamais dupliquer les balises `<html>`, `<head>`, `<body>` dans les templates enfants.
- Placer les blocs `body`, `stylesheets`, `javascripts`, etc. dans `base.html.twig`.
- Utiliser `asset()` pour référencer des fichiers CSS/JS/images.

---

## 🧪 Débogage

Vous pouvez afficher un bloc vide pour vérifier l'héritage :

```twig
{% block body %}{# vide pour test #}{% endblock %}
```

Et dans un template enfant, remplissez ce bloc pour voir s’il s’affiche bien.

---

## 🔗 Ressources

- Documentation officielle Twig : https://twig.symfony.com/doc/
- Documentation Layout Symfony : https://symfony.com/doc/current/templates.html

---
