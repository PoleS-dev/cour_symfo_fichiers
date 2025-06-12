# Créer une entité Utilisateur avec Symfony : make:user

## 📌 Commande à exécuter dans le terminal :
```bash
symfony console make:user
# OU si "symfony" n'est pas reconnu :
php bin/console make:user
```

---

## 🔄 But de cette commande
Cette commande génère automatiquement une classe d'utilisateur (`User.php`) dans le dossier `src/Entity/`.  
Elle prépare tout pour une future authentification (ex: avec des rôles, un mot de passe, etc.).

---

## 🧠 Toutes les questions posées (et leurs significations)

---

### 1️⃣ "The name of the security user class (e.g. User)"

🔹 **Que veut Symfony ?**  
Le nom de la classe que tu veux créer (en général : `User`).

✅ **Tu peux répondre :**
```
User
```

➡️ **Résultat :** Symfony crée une classe `User` dans `src/Entity/`.

---

### 2️⃣ "Do you want to store user data in the database (yes/no)?"

🔹 **Que veut Symfony ?**  
Savoir si tu veux que l'utilisateur soit stocké en base de données.

✅ **Tu dois répondre :**
```
yes
```

➡️ **Résultat :** Symfony ajoute les attributs Doctrine pour créer une vraie table SQL.

---

### 3️⃣ "Enter a property name that will be the unique identifier for the user (e.g. email)"

🔹 **Que veut Symfony ?**  
Quel champ servira d'identifiant de connexion ? (souvent `email` ou `username`)

✅ **Tu peux répondre :**
```
email
```

➡️ **Résultat :** une propriété `email` est ajoutée avec `unique: true`. Ce champ sera utilisé pour le login.

🔁 **Tu peux aussi répondre :**
```
username
```

➡️ Symfony utilisera alors une propriété `username`.  
Exemple généré :

```php
#[ORM\Column(length: 180, unique: true)]
private string $username;

public function getUserIdentifier(): string
{
    return $this->username;
}
```

👉 Cela signifie que l’utilisateur se connectera avec un nom d’utilisateur (et non un email).  
Ton formulaire de connexion devra donc avoir un champ `username`.

---

### 4️⃣ "Will this app need to hash/check user passwords? (yes/no)"

🔹 **Que veut Symfony ?**  
Savoir si l'utilisateur aura un mot de passe à stocker et sécuriser.

✅ **Tu dois répondre :**
```
yes
```

➡️ **Résultat :** Symfony ajoute une propriété `password` et l'interface `PasswordAuthenticatedUserInterface`.

---

## ✅ Une fois terminé
Symfony génère automatiquement :
- Une classe `User.php` dans `src/Entity/`
- Un fichier de migration après `make:migration`
- Une entité prête pour être utilisée avec `make:auth` ou `make:registration-form`

---

## 🚀 Prochaine étape recommandée

Tu peux maintenant :
- Créer une migration avec :
```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
