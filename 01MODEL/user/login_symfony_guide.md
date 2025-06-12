# 🔐 Intégration d'un formulaire de login avec Symfony

Ce guide décrit comment mettre en place un formulaire de connexion avec Symfony à l’aide de la commande `make:auth` (ou `make:security:form` selon la version).

## ✅ Prérequis

- Symfony 6 ou 7
- Un `User` entity déjà créé (via `make:user`)
- Enregistrement fonctionnel (`make:registration-form`)

---

## 🧰 Étape 1 : Générer le formulaire de login

```bash
php bin/console make:auth
```

### Choix proposés :

- Type : `Login form authenticator`
- Nom du service : (laisser par défaut ou `App\Security\LoginFormAuthenticator`)
- Nom du contrôleur : (laisser par défaut ou `SecurityController`)
- Page de connexion : `/login`
- Page de destination après login : `/home` ou `/` selon votre application

---

## 🛠 Étape 2 : Modifier `security.yaml`

Ouvrez le fichier `config/packages/security.yaml` et vérifiez que le contenu ressemble à ceci :

```yaml
security:
    password_hashers:
        App\Entity\User:
            algorithm: auto

    providers:
        app_user_provider:
            entity:
                class: App\Entity\User
                property: email  # ou 'username' selon votre entité

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        main:
            lazy: true
            provider: app_user_provider

            form_login:
                login_path: login
                check_path: login
                default_target_path: home  # redirection après connexion
                username_parameter: email  # ou 'username' selon le champ utilisé
                password_parameter: password

            logout:
                path: logout
                target: login

    access_control:
        - { path: ^/login, roles: PUBLIC_ACCESS }
        - { path: ^/register, roles: PUBLIC_ACCESS }
        - { path: ^/, roles: ROLE_USER }
```

---

## 🖼 Étape 3 : Vérifier le template de connexion

Fichier généré : `templates/security/login.html.twig`

Assurez-vous que les noms des champs correspondent à `username_parameter` et `password_parameter`.

```twig
<form method="post" action="{{ path('login') }}">
    {% if error %}
        <div class="alert alert-danger">{{ error.messageKey|trans(error.messageData, 'security') }}</div>
    {% endif %}

    <label for="inputEmail">Email</label>
    <input type="email" value="{{ last_username }}" name="email" id="inputEmail" required autofocus>

    <label for="inputPassword">Mot de passe</label>
    <input type="password" name="password" id="inputPassword" required>

    <button type="submit">Connexion</button>
</form>
```

---

## 🧪 Étape 4 : Tester le login

1. Lancez le serveur :
   ```bash
   symfony server:start
   ```
2. Accédez à `/login`
3. Utilisez un compte déjà enregistré (via `/register`)

---

## 🛠 Étape 5 : Redirection post-login (optionnel)

Modifiez la route de redirection dans `security.yaml` :

```yaml
form_login:
    default_target_path: dashboard  # par exemple
```

---

## 🚪 Étape 6 : Déconnexion

La déconnexion est déjà prise en charge avec la route `/logout`.

Le contrôleur associé peut rester vide :

```php
#[Route(path: '/logout', name: 'logout')]
public function logout(): void
{
    throw new \LogicException('Intercepted by Symfony.');
}
```

---

## 🧼 Étape 7 : Sécuriser les routes

Utilisez `access_control` pour protéger vos pages :

```yaml
access_control:
    - { path: ^/admin, roles: ROLE_ADMIN }
    - { path: ^/profile, roles: ROLE_USER }
```

---

## ✅ Résultat final

- `/register` permet d’enregistrer un utilisateur
- `/login` permet de se connecter
- `/logout` déconnecte l’utilisateur
- Les routes sécurisées ne sont accessibles qu’après authentification

---
