# Symfony & Doctrine – Le Repository

---

## 1️⃣ C’EST QUOI UN REPOSITORY ?

Un **repository** est une classe spéciale utilisée pour interagir avec la base de données
pour une entité donnée (ex : `Product`, `User`…).

Doctrine utilise un "repository" comme couche intermédiaire entre la base et ton code PHP.

➡️ Chaque entité a son propre repository.

**Exemple :**  
`ProductRepository` pour l'entité `Product`.

---

## 2️⃣ COMMENT IL EST LIÉ À UNE ENTITÉ ?

Dans l'entité :

```php
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    // ...
}
```

Symfony sait automatiquement que toutes les requêtes liées à `Product` passent par `ProductRepository`.

---

## 3️⃣ GÉNÉRER UN REPOSITORY

Commande :

```bash
php bin/console make:repository Product
```

Cela crée automatiquement le fichier suivant :

```
/src/Repository/ProductRepository.php
```

---

## 4️⃣ MÉTHODES DISPONIBLES PAR DÉFAUT DANS UN REPOSITORY

- `find($id)` : Recherche par identifiant
- `findAll()` : Récupère toutes les lignes de la table
- `findBy(array $criteria)` : Filtrage avec un tableau de critères
- `findOneBy(array $criteria)` : Un seul résultat avec conditions

**Exemples d’utilisation :**

```php
$productRepository->find(1);
$productRepository->findAll();
$productRepository->findBy(['price' => 20.0]);
$productRepository->findOneBy(['name' => 'T-shirt']);
```

---

## 5️⃣ CRÉER UNE MÉTHODE PERSONNALISÉE AVEC QUERYBUILDER

### Exemple :

```php
public function findExpensiveProducts(float $minPrice): array
{
    return $this->createQueryBuilder('p')
        ->andWhere('p.price > :min')
        ->setParameter('min', $minPrice)
        ->orderBy('p.price', 'DESC')
        ->getQuery()
        ->getResult();
}
```

### Utilisation dans un contrôleur :

```php
$products = $productRepository->findExpensiveProducts(50.0);
```

---

## 6️⃣ POURQUOI L’UTILISER ?

✅ **Avantages** :

- Tu centralises toutes les requêtes liées à une entité
- Tu peux nommer clairement des requêtes personnalisées
- Le code est plus **propre** et **maintenable**

---

## 7️⃣ RÉSUMÉ

| Élément          | Rôle                                      |
|------------------|-------------------------------------------|
| Repository       | Classe liée à une entité                  |
| Méthodes de base | `find()`, `findAll()`, `findBy()`, etc.  |
| Perso            | Méthodes personnalisées avec QueryBuilder |
| Utilisation      | Appelé dans les contrôleurs/services      |
