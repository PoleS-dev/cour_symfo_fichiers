# EXERCICE SYMFONY — PROJET COMPLET : UTILISATEURS, ADMIN, CRUD PRODUITS ET UPLOAD D’IMAGE

---

## 🎯 OBJECTIFS PÉDAGOGIQUES

- Créer un projet Symfony complet
- Gérer des utilisateurs avec authentification (login/register)
- Implémenter un CRUD de produits
- Mettre en place un espace d’administration
- Gérer l’upload d’image via un formulaire

---

## ✅ ÉTAPES À SUIVRE

---

### 1️⃣ CRÉER UN NOUVEAU PROJET SYMFONY

```bash

```

---

### 2️⃣ CRÉER UNE ENTITÉ USER

```bash

```

Champs :
- `username` (unique)
- `password` (hashé automatiquement)

---

### 3️⃣ GÉNÉRER LE LOGIN ET REGISTER

```bash

```

---

### 4️⃣ CRÉER LA BASE DE DONNÉES

1. Configurer `.env`  :

```dans le fichier .env puis faire les/la ligne/s de commande nécessaire 

```

---

### 5️⃣ CRÉER UNE ENTITÉ PRODUIT

```bash
php bin/console make:entity Produit
```

Champs :
- `nom` (string)
- `description` (text)
- `prix` (float)
- `image` (string) : stocke le **nom du fichier image**

---

### 6️⃣ GÉNÉRER LE CRUD POUR PRODUIT

```bash

```

---

### 7️⃣ DÉFINIR UN UTILISATEUR ADMIN

- Attribuer le rôle `ROLE_ADMIN` à un utilisateur manuellement :
  - via la base de données
  - protéger les routes admin avec fichier security.yaml dans config/packages/security.yaml
  

---
### 8️⃣ AFFICHER LES PRODUITS DANS LA PAGE ACCUEIL FAIRE UN HEADER AVEC LIEN VALIDE 

- Creation controller puis vue twig
- Les produits seront affichés dans la page accueil
- Le header sera affiché sur toutes les pages
- Au click des produits  affichera  la page produit id 

```bash
```
### 9️⃣ CREER UNE PAGE PROFIL QUI AFFICHE LES INFORMATIONS DE L'UTILISATEUR CONNECTE

```bash
Creation controller puis vue twig

```


### 10️⃣ GÉRER L’UPLOAD D’IMAGE

Dans `ProduitType.php`, ajouter un champ non mappé :

```php
use Symfony\Component\Form\Extension\Core\Type\FileType;



Dans le contrôleur (méthodes `new()` et `edit()`):



Configurer le service dans `services.yaml` : parameters :


---

## ✅ RÉSULTAT ATTENDU

- ✅ Un utilisateur peut s’enregistrer et se connecter
- ✅ Un admin peut accéder à `/admin/produit`
- ✅ CRUD complet sur les produits
- ✅ Un utilisateur peut accéder à sa page profil
- ✅ un page produitid sera affiché avec les informations du produit
- ✅ Les images seront stockées dans `/public/images`


---

## 🎁 BONUS (FACULTATIF)


- ✅ Ajouter des **messages flash** :
```php
$this->addFlash('success', 'Produit ajouté avec succès !');
```
---

## ✅ VALIDATION DE L’EXERCICE

| Objectif                                                         |Statut |
|---------------------------------- ------------------------------ |-------|
| Authentification fonctionnelle                                   |✅ OK  |
| CRUD produit fonctionnel                                         |✅ OK  |
| Upload image opérationnel                                        |✅ OK  |
| Rôle admin actif et vérifié                                      |✅ OK  |
| un utilisateur peut accéder à sa page profil                     |✅ OK  |
| un page produitid sera affiché avec les informations du produit  |✅ OK  |
| les images seront stockées dans /public/images                   |✅ OK  |
| les images seront affichées sur les pages du produit             |✅ OK  |
| Application fonctionne sans erreur                               |✅ OK  |
| 

