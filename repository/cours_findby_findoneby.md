
# Cours : Utilisation de `findBy` et `findOneBy` avec Doctrine ORM

## Introduction

Dans Symfony, l'interaction avec la base de données est facilitée par Doctrine ORM.
Les méthodes `findBy` et `findOneBy` sont utilisées pour récupérer des entités selon des critères spécifiques.

## 1. `findOneBy`

### Définition
`findOneBy` permet de récupérer **une seule entité** correspondant aux critères donnés.

### Syntaxe
```php
$entity = $repository->findOneBy(['champ' => 'valeur']);
```

### Exemple
Supposons une entité `User` avec les champs `id`, `email`, `name`.

```php
$user = $userRepository->findOneBy(['email' => 'user@example.com']);
```
Ce code va retourner l'utilisateur ayant pour email `user@example.com` ou `null` s'il n'existe pas.

### Remarques
- Retourne un seul objet ou `null`.
- Si plusieurs entités correspondent, Doctrine en renverra **une seule**, généralement la première.

---

## 2. `findBy`

### Définition
`findBy` permet de récupérer **plusieurs entités** correspondant aux critères donnés.

### Syntaxe
```php
$entities = $repository->findBy(
    ['champ' => 'valeur'],
    ['champTri' => 'ASC|DESC'],
    $limite,
    $offset
);
```

- **Critères** : tableau clé-valeur des conditions de filtrage.
- **Ordre** *(optionnel)* : tableau pour spécifier le tri.
- **Limite** *(optionnel)* : nombre maximum de résultats.
- **Offset** *(optionnel)* : position de départ.

### Exemple
Lister tous les articles d'une catégorie spécifique, triés par date décroissante, limité à 10 :
```php
$articles = $articleRepository->findBy(
    ['category' => 'technology'],
    ['publishedAt' => 'DESC'],
    10,
    0
);

Supposons que nous avons une entité Order avec les champs suivants :

id

customer (relation ManyToOne vers Customer)

status (ex: pending, completed, cancelled)

createdAt

Objectif
Afficher toutes les commandes d un client spécifique, triées de la plus récente à la plus ancienne,  uniquement celles avec le statut completed.

public function getCompletedOrdersByCustomer(OrderRepository $orderRepository, int $customerId)
{
    $orders = $orderRepository->findBy(
        [
            'customer' => $customerId,
            'status' => 'completed'
        ],
        [
            'createdAt' => 'DESC'
        ]
    );

    return $this->render('orders/list.html.twig', [
        'orders' => $orders,
    ]);
}

Explications
Critères : On filtre sur customer et status.

Tri : On trie par createdAt en ordre décroissant (DESC), donc les commandes les plus récentes d abord.

Limite et Offset : non spécifiés ici, donc toutes les commandes correspondantes sont retournées.


```

### Remarques
- Retourne un **tableau d'objets**.
- Si aucune entité ne correspond, retourne un tableau vide.

---

## 3. Comparatif rapide

| Méthode     | Nombre de résultats | Retour            |
|-------------|---------------------|-------------------|
| `findOneBy` | Un seul              | Objet ou `null`    |
| `findBy`    | Plusieurs            | Tableau d'objets  |

---

## 4. Cas d'utilisation typiques

- **`findOneBy`** : Authentification (trouver un utilisateur par email).
- **`findBy`** : Affichage d'une liste filtrée (articles par catégorie, commandes par client).

## 5. Bonnes pratiques

- Utilisez `findOneBy` uniquement si vous êtes certain qu'il n'y a qu'un seul résultat attendu.
- Privilégiez l'utilisation d'un repository custom avec des méthodes explicites pour une meilleure lisibilité :
```php
public function findUserByEmail(string $email): ?User
{
    return $this->findOneBy(['email' => $email]);
}
```

---

## 6. Ressources officielles
- [Doctrine ORM Documentation](https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/working-with-objects.html)
- [Symfony Doctrine Docs](https://symfony.com/doc/current/doctrine.html)

