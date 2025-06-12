# 🚀 Introduction aux bases de Symfony

Symfony est un framework PHP moderne et robuste utilisé pour développer des applications web de manière rapide, sécurisée et bien structurée.

---

## 🧱 Structure de base d’un projet Symfony

Après avoir créé un projet avec :

```bash
symfony new mon_projet --webapp
```

Voici les dossiers importants :

- `src/` : code source (contrôleurs, entités, services)
- `templates/` : vues Twig
- `config/` : configuration (routes, services, sécurité)
- `public/` : point d'entrée web (`index.php`)
- `var/` : fichiers temporaires (logs, cache)
- `vendor/` : dépendances installées via Composer

---

## 📍 Routes et contrôleurs

### Créer un contrôleur

```bash
php bin/console make:controller NomDuController
```

Cela crée :

- `src/Controller/NomDuController.php`
- `templates/nom_du/` avec un fichier `.html.twig`

### Exemple de route avec attribut :

```php
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bonjour', name: 'app_bonjour')]
public function bonjour(): Response
{
    return new Response('Bonjour Symfony !');
}
```

---

## 📄 Vue avec Twig

Dans `templates/`, vous utilisez Twig pour générer du HTML :

```twig
<h1>Bienvenue {{ nom }}</h1>
```

Appel depuis le contrôleur :

```php
return $this->render('mon_template.html.twig', [
    'nom' => 'Jean',
]);
```

---

## 🗄 Entités et base de données

### Créer une entité

```bash
php bin/console make:entity
```

### Exécuter la migration

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

---

## 🧾 Formulaires

### Générer un formulaire :

```bash
php bin/console make:form
```

### Dans un contrôleur :

```php
$form = $this->createForm(ExempleType::class, $entity);
$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
    // traitement
}
```

---

## 🔐 Sécurité

Symfony utilise un système puissant de firewall :

- Définir les accès dans `security.yaml`
- Créer des utilisateurs (`make:user`)
- Créer une authentification (`make:auth`)

---

## ✅ Commandes utiles

```bash
php bin/console cache:clear      # Vider le cache
php bin/console debug:router     # Affiche toutes les routes
php bin/console doctrine:schema:update --force  # Mettre à jour la DB
```

---

## 🔗 Ressources

- Documentation Symfony : https://symfony.com/doc/
- Tutoriels officiels : https://symfonycasts.com/
- Commandes disponibles : `php bin/console list`

---
