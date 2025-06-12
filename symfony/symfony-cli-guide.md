# Symfony CLI – Installation et Commandes Utiles

---

## 1️⃣ INSTALLATION DE SYMFONY CLI

🔗 **Site officiel** : https://symfony.com/download

### 📥 Pour Linux / macOS :
```bash
curl -sS https://get.symfony.com/cli/installer | bash
# Ajouter ~/.symfony/bin à votre $PATH
```

### 🪟 Pour Windows :
Télécharger l’installeur directement depuis :  
👉 https://symfony.com/download

### ✅ Vérifier l’installation :
```bash
symfony -v
```

---

## 2️⃣ CRÉER UN PROJET SYMFONY

### 💡 Version complète (avec Twig, Webpack, Doctrine, etc.) :
```bash
symfony new mon_projet --webapp
```

### ⚙️ Version minimale :
```bash
symfony new mon_projet
```

➡️ Cette version contient uniquement le noyau Symfony, sans :
- Doctrine ORM
- Twig
- Webpack Encore
- Formulaires
- Sécurité

### 📁 Se déplacer dans le dossier du projet :
```bash
cd mon_projet
```

---

## 3️⃣ LANCER LE SERVEUR LOCAL

```bash
symfony serve          # Lancer le serveur en mode normal
symfony serve -d       # Lancer en arrière-plan (daemon)
symfony open:local     # Ouvrir le site local dans le navigateur
```

---

## 4️⃣ VÉRIFIER LES DÉPENDANCES

```bash
symfony check:requirements
```

---

## 5️⃣ COMMANDES UTILES

```bash
symfony console list                           # Lister toutes les commandes disponibles
symfony console make:controller Nom            # Générer un contrôleur
symfony console make:entity Nom                # Créer une entité Doctrine
symfony console make:migration                 # Créer une migration
symfony console doctrine:migrations:migrate    # Appliquer les migrations
symfony console make:form NomFormType          # Créer un formulaire
symfony console make:auth                      # Créer un système d’authentification
symfony console debug:router                   # Lister les routes disponibles
symfony console debug:container                # Afficher les services du container
```

---

## 6️⃣ NETTOYER LE CACHE

```bash
symfony console cache:clear
```

---

## 7️⃣ TEST DE BON FONCTIONNEMENT

Lancer le serveur, puis visiter :  
🌐 https://127.0.0.1:8000

---

## ℹ️ NOTE

Symfony CLI est un outil très utile pour :
- Créer rapidement de nouveaux projets
- Servir localement votre application
- Automatiser les tâches récurrentes dans le développement Symfony
