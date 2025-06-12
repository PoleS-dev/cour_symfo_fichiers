# Explication du Modèle MVC (Modèle-Vue-Contrôleur)

---

## 1️⃣ Le modèle MVC en général

Le modèle **MVC** est une architecture logicielle qui sépare une application en trois composants principaux :

### 🧩 Modèle (Model)
- Représente les **données** de l'application.
- Contient la **logique métier** (règles de gestion, calculs, traitement).
- Communique avec la **base de données**.

### 🎨 Vue (View)
- S’occupe **uniquement de l'affichage**.
- N’affiche que les **données préparées** par le contrôleur.
- Ne contient **aucune logique métier**.

### 🎮 Contrôleur (Controller)
- Intermédiaire entre la vue et le modèle.
- Reçoit les **requêtes utilisateur**, interagit avec le modèle si nécessaire, puis renvoie une vue.
- Contrôle **le flux logique** de l’application.

---

## 2️⃣ Application du MVC dans Symfony

### 🧩 Modèle dans Symfony
- Les **entités** (dans `src/Entity/`) représentent les **tables** de la base.
- Les **repositories** (dans `src/Repository/`) servent à **interroger** ces entités.
- Symfony utilise **Doctrine ORM** pour gérer les entités comme des objets PHP.

---

### 🎨 Vue (View) dans Symfony
- Ce sont les fichiers `.twig` dans le dossier `templates/`.
- Ils permettent d’afficher les données avec la syntaxe Twig :
```twig
{{ produit.nom }}
```
- Tu peux utiliser `form_widget()`, `form_label()` ou des boucles pour créer un affichage dynamique.

---

### 🎮 Contrôleur (Controller) dans Symfony
- Situés dans `src/Controller/`.
- Chaque méthode (appelée **action**) correspond à une **route** (URL) et retourne une **vue**.

### Exemple de contrôleur :
```php
// src/Controller/ProduitController.php

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;

class ProduitController extends AbstractController
{
    #[Route('/produits', name: 'liste_produits')]
    public function index(ProduitRepository $repository): Response
    {
        $produits = $repository->findAll();

        return $this->render('produit/index.html.twig', [
            'produits' => $produits
        ]);
    }
}
```

---

## 📦 Repository dans Symfony

- Chaque entité peut avoir un **repository dédié**.
- Il contient des **méthodes personnalisées** pour les requêtes spécifiques.

### Exemple de repository personnalisé :
```php
// src/Repository/ProduitRepository.php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function findProduitsEnStock(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.stock > 0')
            ->orderBy('p.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
```

---

## ✅ Résumé

| Élément     | Dossier Symfony       | Rôle principal                            |
|-------------|------------------------|--------------------------------------------|
| Modèle      | `src/Entity/`          | Représente les données                     |
| Repository  | `src/Repository/`      | Fournit les méthodes pour interroger la BDD|
| Contrôleur  | `src/Controller/`      | Gère les requêtes et appelle les vues      |
| Vue         | `templates/`           | Affiche les données avec Twig              |
