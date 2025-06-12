# Symfony - Base des Entités (Doctrine)

## 1. CRÉER UNE ENTITÉ
```bash
php bin/console make:entity
# ou
symfony console make:entity
```

> Exemple :
> Nom de l'entité : Product  
> Champs : name (string), price (float), createdAt (datetime)

## 2. EXEMPLE D'ENTITÉ
```php
// src/Entity/Product.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $name;

    #[ORM\Column(type: "float")]
    private $price;

    #[ORM\Column(type: "datetime")]
    private $createdAt;

    // Getters & Setters...
}
```

## 3. CRÉER LA BASE & MIGRATIONS

**Créer la BDD :**
```bash
php bin/console doctrine:database:create
# ou
symfony console doctrine:database:create
```

**Créer une migration :**
```bash
php bin/console make:migration
# ou
symfony console make:migration
```

**Appliquer la migration :**
```bash
php bin/console doctrine:migrations:migrate
# ou
symfony console doctrine:migrations:migrate
```
