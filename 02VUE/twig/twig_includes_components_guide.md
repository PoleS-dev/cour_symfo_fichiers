# 🧩 Utilisation des `include` et `composants` dans Twig (Symfony)

Twig permet de **réutiliser des morceaux de template** à l’aide de l’instruction `include` ou via les **composants Twig (fragments réutilisables)**.

---

## 🔹 `include` : inclure un fichier partiel

```twig
{% include 'partials/_header.html.twig' %}
```

Cela insère le contenu du fichier `_header.html.twig` à cet endroit précis.

### 🔁 Exemple d'utilisation :

#### Fichier `base.html.twig`

```twig
<body>
    {% include 'partials/_navbar.html.twig' %}
    {% block body %}{% endblock %}
</body>
```

#### Fichier `partials/_navbar.html.twig`

```twig
<nav>
    <ul>
        <li><a href="{{ path('home') }}">Accueil</a></li>
        {% if app.user %}
            <li><a href="{{ path('logout') }}">Déconnexion</a></li>
        {% else %}
            <li><a href="{{ path('login') }}">Connexion</a></li>
        {% endif %}
    </ul>
</nav>
```

---

## 🔸 Passer des variables à un `include`

```twig
{% include 'partials/_user_card.html.twig' with { 'user': user } %}
```

Dans `_user_card.html.twig` :

```twig
<div class="user-card">
    <h2>{{ user.name }}</h2>
    <p>Email : {{ user.email }}</p>
</div>
```

---

## 🧩 Les `composants` Twig (nouveauté Symfony 6.2+)

Symfony propose aussi les **Twig Components** : des classes PHP liées à un template Twig, idéales pour créer des blocs réutilisables, dynamiques et typés.

### 📦 Installer le support des composants :

```bash
composer require symfony/twig-component
```

---

## ⚙️ Déclaration d’un composant

### 1. Créer la classe PHP (dans `src/Twig/Component`)

```php
namespace App\Twig\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'user_card')]
class UserCardComponent
{
    public \App\Entity\User $user;
}
```

### 2. Créer le template associé : `components/user_card.html.twig`

```twig
<div class="user-card">
    <h3>{{ user.name }}</h3>
    <p>Email : {{ user.email }}</p>
</div>
```

---

## 🧑‍💻 Utilisation d’un composant dans un template

```twig
<x-user-card :user="user" />
```

> Syntaxe similaire à du Web Component — très lisible et propre.

---

## ✅ Comparaison rapide

| Méthode      | Type de contenu | Variables disponibles | Dynamique | Réutilisable |
|--------------|-----------------|------------------------|-----------|--------------|
| `include`    | Statique        | Manuellement passées   | Moyennement | Oui          |
| Composants   | Dynamique (PHP) | Propriétés publiques    | Oui       | Oui          |

---

## 💡 Bonnes pratiques

- Utilisez `include` pour du contenu **simple** (menus, footers).
- Utilisez les **composants Twig** pour des blocs **dynamiques et isolés**.
- Nommez les fichiers inclus avec un `_` initial pour les distinguer (`_header.html.twig`, `_footer.html.twig`).

---

## 🔗 Ressources

- Twig Include : https://twig.symfony.com/doc/3.x/tags/include.html
- Composants Twig : https://symfony.com/doc/current/ux/twig-component.html

---
