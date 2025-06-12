## Symfony & Doctrine – Relations entre Entités

---

## 1️⃣ TYPES DE RELATIONS

- `@OneToMany`   : Une entité A possède plusieurs B  
- `@ManyToOne`   : Plusieurs entités A appartiennent à une B  
- `@OneToOne`    : Relation unique dans chaque sens  
- `@ManyToMany`  : Plusieurs A liés à plusieurs B  

---

## 2️⃣ EXEMPLE : ManyToOne / OneToMany

Un `Product` appartient à une `Category` :

```php
// src/Entity/Product.php
#[ORM\ManyToOne(inversedBy: 'products')]
private ?Category $category = null;

// src/Entity/Category.php
#[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
private Collection $products;
```

---

## 3️⃣ EXEMPLE : OneToOne

```php
// src/Entity/User.php
#[ORM\OneToOne(mappedBy: 'user', targetEntity: Profile::class, cascade: ['persist', 'remove'])]
private ?Profile $profile = null;

// src/Entity/Profile.php
#[ORM\OneToOne(inversedBy: 'profile', targetEntity: User::class)]
private ?User $user = null;
```

---

## 4️⃣ EXEMPLE : ManyToMany

```php
// src/Entity/Student.php
#[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'students')]
private Collection $courses;

// src/Entity/Course.php
#[ORM\ManyToMany(mappedBy: 'courses', targetEntity: Student::class)]
private Collection $students;
```

---

## 5️⃣ COMMANDES POUR GÉNÉRER UNE RELATION

```bash
php bin/console make:entity
```

> Quand il te demande un type :
- Tu peux répondre : `string`, `int`, `datetime`, etc.  
- Ou bien une relation : `ManyToOne`, `OneToMany`, `OneToOne`, `ManyToMany`

---

## 6️⃣ GESTION DE LA COLLECTION

Pour les relations multiples (`OneToMany`, `ManyToMany`), utilise :

```php
use Doctrine\Common\Collections\ArrayCollection;

$this->products = new ArrayCollection();
```

Et crée des méthodes dans ton entité :

```php
public function addProduct(Product $product): static
{
    if (!$this->products->contains($product)) {
        $this->products[] = $product;
        $product->setCategory($this);
    }

    return $this;
}

public function removeProduct(Product $product): static
{
    if ($this->products->removeElement($product)) {
        if ($product->getCategory() === $this) {
            $product->setCategory(null);
        }
    }

    return $this;
}
```

---

## 7️⃣ MIGRATIONS

N’oublie pas de mettre à jour la base de données après toute modification de relation :

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
