# Symfony – Comprendre les Contrôleurs

---

## 1️⃣ C’EST QUOI UN CONTRÔLEUR ?

Un **contrôleur** est une classe PHP responsable de :
- Répondre à une requête HTTP
- Traiter les données (via les services ou le modèle)
- Choisir une **vue** à retourner à l'utilisateur

C'est un **composant central** dans l'architecture **MVC** de Symfony.

---

## 2️⃣ EMPLACEMENT DES CONTRÔLEURS

Tous les contrôleurs se trouvent dans :

```
/src/Controller/
```

Par convention, leur nom se termine par `Controller`.

---

## 3️⃣ EXEMPLE DE CONTRÔLEUR BASIQUE

```php
// src/Controller/HomeController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'message' => 'Bienvenue sur Symfony !'
        ]);
    }
}
```

---

## 4️⃣ COMPOSANTS PRINCIPAUX

- `AbstractController` : classe de base fournie par Symfony avec des helpers intégrés (`render`, `redirectToRoute`, etc.)
- `Response` : objet représentant la réponse HTTP envoyée au navigateur
- `Route` : définit à quelle URL la méthode répond

---

## 5️⃣ LIER UNE VUE (TEMPLATE TWIG)

Dans l’exemple ci-dessus :

```php
return $this->render('home/index.html.twig', [
    'message' => 'Bienvenue sur Symfony !'
]);
```

Cette méthode :
- Charge le fichier `templates/home/index.html.twig`
- Transmet la variable `message` à la vue

---

## 6️⃣ RÉCUPÉRER DES DONNÉES VIA UN REPOSITORY

```php
#[Route('/produits', name: 'produits')]
public function produits(ProduitRepository $repo): Response
{
    $produits = $repo->findAll();

    return $this->render('produit/index.html.twig', [
        'produits' => $produits
    ]);
}
```

Symfony **injecte automatiquement** le repository demandé si c’est un service.

---

## 7️⃣ REDIRECTION

Pour rediriger vers une autre page :

```php
return $this->redirectToRoute('autre_route');
```

---

## 8️⃣ JSON & API

Un contrôleur peut aussi retourner des données JSON :

```php
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/data')]
public function api(): JsonResponse
{
    return $this->json(['success' => true, 'message' => 'OK']);
}
```

---

## ✅ RÉSUMÉ

| Élément       | Description                                          |
|---------------|------------------------------------------------------|
| `Route`       | Lie une URL à une méthode                            |
| `render()`    | Affiche un template Twig                             |
| `redirectToRoute()` | Redirige vers une autre route                |
| `json()`      | Retourne une réponse JSON                            |
| `Response`    | Objet Symfony représentant une réponse HTTP          |

📚 Documentation : [Symfony - The Controller](https://symfony.com/doc/current/controller.html)
