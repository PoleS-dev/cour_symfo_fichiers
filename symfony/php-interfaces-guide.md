# PHP – Comprendre les Interfaces

---

## 🧩 Qu'est-ce qu'une interface en PHP ?

Une **interface** définit un **contrat** : une liste de méthodes que **toute classe** qui l’implémente **doit obligatoirement définir**.

- Elle **ne contient aucune logique**, uniquement les signatures des méthodes.
- Outil fondamental pour écrire un **code structuré**, **maintenable** et **orienté objet**.

---

## 🛠️ Exemple de base

```php
// Déclaration d'une interface
interface Vehicule {
    public function demarrer();
    public function arreter();
}

// Une classe qui implémente l'interface
class Voiture implements Vehicule {
    public function demarrer() {
        echo "🚗 La voiture démarre.\n";
    }

    public function arreter() {
        echo "🛑 La voiture s'arrête.\n";
    }
}

// Utilisation
$maVoiture = new Voiture();
$maVoiture->demarrer();
$maVoiture->arreter();
```

---

## 🧠 Pourquoi utiliser des interfaces ?

✅ Permet de définir une **structure commune** pour plusieurs classes  
✅ Facilite le **polymorphisme** et l'**injection de dépendances**  
✅ Très utilisé dans Symfony (services, sécurité, formulaires, etc.)

---

## 🎯 Exemple réel avec Symfony : UserInterface

Symfony impose que toute classe utilisateur implémente cette interface :

```php
interface UserInterface {
    public function getRoles(): array;
    public function getPassword(): ?string;
    public function getUserIdentifier(): string;
    public function eraseCredentials(): void;
}
```

Et voici une classe `User` qui respecte ce contrat :

```php
class User implements UserInterface {
    private string $email;
    private string $password;

    public function getRoles(): array {
        return ['ROLE_USER'];
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function getUserIdentifier(): string {
        return $this->email;
    }

    public function eraseCredentials(): void {
        // Ici, on pourrait effacer des données sensibles en mémoire
    }
}
```

---

## ✅ Résumé final

| Mot-clé         | Rôle                                                                 |
|------------------|----------------------------------------------------------------------|
| `interface`       | Déclare un contrat (liste de méthodes sans logique)                |
| `implements`      | Force une classe à implémenter toutes les méthodes de l’interface  |
| `abstract class`  | Classe abstraite qui peut contenir des méthodes concrètes ou abstraites |

Une interface est idéale pour garantir **qu’un objet respecte une structure**, tout en laissant **liberté totale sur la logique interne**.

---

📚 Documentation : [PHP Interfaces – Official](https://www.php.net/manual/fr/language.oop5.interfaces.php)
