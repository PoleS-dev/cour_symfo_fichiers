# Symfony - Système de Routing

---

## 1️⃣ DÉFINIR UNE ROUTE AVEC ATTRIBUTS

Symfony permet de définir des routes directement au-dessus des méthodes de contrôleur avec des **attributs PHP** (à partir de Symfony 6+).

```php
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits', name: 'produits_liste')]
public function liste()
{
    // code ici
}
```

- `/produits` : chemin de l’URL
- `name: 'produits_liste'` : nom de la route pour y accéder dans Twig ou les redirections

---

## 2️⃣ DÉFINIR UNE ROUTE DANS UN FICHIER YAML (optionnel)

Si tu préfères la configuration YAML, tu peux le faire dans `config/routes.yaml` :

```yaml
produit_liste:
    path: /produits
    controller: App\Controller\ProduitController::liste
```

---

## 3️⃣ VÉRIFIER LES ROUTES

Pour voir toutes les routes définies dans ton application :

```bash
php bin/console debug:router
```

Ce qui affichera :
- Le nom de la route
- Le chemin
- Le contrôleur
- Les méthodes HTTP acceptées

---

## 4️⃣ GÉNÉRER UNE URL DANS TWIG

Dans un fichier `.twig`, utilise la fonction `path()` pour générer une URL à partir du nom de la route :

```twig
<a href="{{ path('produits_liste') }}">Voir les produits</a>
```

Cette méthode est préférable à l’écriture directe de l’URL (`/produits`), car elle s’adapte automatiquement aux changements futurs de chemin.

---

## 5️⃣ REDIRIGER DANS UN CONTRÔLEUR

Depuis un contrôleur Symfony, tu peux rediriger vers une autre route avec :

```php
return $this->redirectToRoute('produits_liste');
```

---

## ✅ Résumé

| Élément            | Description                                  |
|--------------------|----------------------------------------------|
| `#[Route(...)]`    | Définition de route avec attribut PHP        |
| YAML               | Alternative de config dans `routes.yaml`     |
| `debug:router`     | Commande pour voir toutes les routes         |
| `path()`           | Génère un lien dans un template Twig         |
| `redirectToRoute()`| Redirige dans un contrôleur vers une route   |

📚 Plus d'infos : [Symfony Routing Docs](https://symfony.com/doc/current/routing.html)
