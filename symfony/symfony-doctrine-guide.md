# Doctrine ORM avec Symfony – Guide Complet

---

## 1️⃣ C'EST QUOI UN ORM ?

**ORM = Object-Relational Mapping (Mappage Objet-Relationnel)**

Un ORM permet de manipuler une base de données relationnelle (MySQL, PostgreSQL, etc.)
avec du code orienté objet (PHP, Java…).

🔁 **Au lieu d’écrire :**
```sql
SELECT * FROM product WHERE id = 1
```

✅ **Tu écris :**
```php
$product = $productRepository->find(1);
```

Doctrine (l’ORM de Symfony) se charge de convertir ça en SQL.

---

## 2️⃣ POURQUOI UTILISER UN ORM ?

✅ **Avantages :**
- Plus besoin d’écrire de SQL directement
- Code plus lisible et orienté objet
- Facilite les relations entre objets (produits, utilisateurs…)
- Indépendant du SGBD (MySQL, SQLite, PostgreSQL…)
- Support des **migrations** pour gérer l’évolution du schéma

❌ **Inconvénients :**
- Moins performant que du SQL brut (dans certains cas)
- Complexité des requêtes personnalisées plus élevée

---

## 3️⃣ COMMENT FONCTIONNE DOCTRINE DANS SYMFONY ?

Symfony utilise Doctrine pour :
- Mapper les **classes PHP** (entités) avec les **tables SQL**
- Fournir des **repositories** pour accéder aux données
- Gérer les **relations** (OneToMany, ManyToOne, etc.)
- Générer le **schéma de la base automatiquement**

---

## 4️⃣ CRÉATION D’UNE ENTITÉ

Commande :

```bash
php bin/console make:entity
```

Tu entres :
- Le nom de l’entité (ex : `Product`)
- Les champs (`name: string`, `price: float`, etc.)

Doctrine crée :
```php
// src/Entity/Product.php
#[ORM\Column(type: 'string', length: 255)]
private $name;
```

Chaque champ = une colonne dans la base

---

## 5️⃣ CRÉATION ET MISE À JOUR DE LA BASE

### Créer la base :
```bash
php bin/console doctrine:database:create
```

### Créer une migration :
```bash
php bin/console make:migration
```

### Appliquer la migration :
```bash
php bin/console doctrine:migrations:migrate
```

Doctrine génère et applique le SQL nécessaire automatiquement.

---

## 6️⃣ INSÉRER ET LIRE DES DONNÉES

### Insertion :
```php
$product = new Product();
$product->setName('Chaussure');
$product->setPrice(99.99);

$entityManager->persist($product);
$entityManager->flush();
```

### Lecture :
```php
$product = $productRepository->find(1);
$tous = $productRepository->findAll();
$filtrés = $productRepository->findBy(['price' => 99.99]);
```

---

## 7️⃣ RELATIONS ENTRE ENTITÉS

Exemple : Une `Category` a plusieurs `Product`, et un `Product` a une seule `Category`

```php
// Product.php
#[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
private ?Category $category = null;

// Category.php
#[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
private Collection $products;
```

Doctrine gère les **clés étrangères** automatiquement ✅

---

## 8️⃣ COMMANDES DOCTRINE LES PLUS UTILES

```bash
php bin/console doctrine:database:create              # Créer la base
php bin/console make:entity                           # Créer une entité
php bin/console make:migration                        # Générer une migration
php bin/console doctrine:migrations:migrate           # Appliquer une migration
php bin/console doctrine:mapping:info                 # Voir les entités connues
php bin/console doctrine:query:sql 'SELECT * FROM product' # Exécuter une requête SQL
php bin/console doctrine:database:drop --force        # Supprimer la base (danger)
```

---

## 9️⃣ BONNES PRATIQUES AVEC DOCTRINE

- Ne jamais modifier la base **manuellement**
- Toujours passer par les entités + `make:migration`
- Utiliser des types compatibles Doctrine (`string`, `float`, `datetime`, etc.)
- Toujours faire `flush()` après un `persist()`
- Utiliser les **repositories** pour encapsuler les requêtes complexes

---

## 🔟 DOCTRINE AVEC CONNEXION À MYSQL

Dans le fichier `.env` :

```
DATABASE_URL="mysql://root:root@127.0.0.1:3306/ma_base"
```

Puis :

```bash
php bin/console doctrine:database:create
```

Doctrine se connecte à MySQL et crée automatiquement les tables nécessaires.

---

📚 Pour aller plus loin :
- [Documentation officielle Doctrine](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/)
- [Symfony + Doctrine](https://symfony.com/doc/current/doctrine.html)
