
# 🌟 Cours Symfony : `Request`, `POST`, `GET`, `Session` et `Cookies`

Symfony offre de puissants outils via la classe `Request` pour interagir avec les données HTTP.

---

# 1. 📥 **GET Request**

## Qu'est-ce que `GET` ?
- Une requête **GET** est utilisée pour **récupérer** des données.
- Les **données sont passées dans l'URL** sous forme de **query parameters**.

**Exemple URL :**
```
/search?query=ordinateur
```

**Récupérer une valeur GET avec Symfony :**

```php
use Symfony\Component\HttpFoundation\Request;

public function search(Request $request)
{
    $query = $request->query->get('query');
    // Utilisation du paramètre
}
```

---

# 2. 📤 **POST Request**

## Qu'est-ce que `POST` ?
- Une requête **POST** est utilisée pour **envoyer** des données au serveur.
- Les données ne sont **pas visibles dans l'URL**.

**Récupérer une valeur POST avec Symfony :**

```php
public function submit(Request $request)
{
    $name = $request->request->get('name');
    // Traitement du formulaire
}
```

**Formulaire HTML exemple :**

```html
<form method="post" action="/submit">
    <input type="text" name="name">
    <button type="submit">Envoyer</button>
</form>
```

---

# 3. 🧭 **Session**

## Qu'est-ce qu'une `Session` ?
- Une **session** permet de **stocker des informations** entre plusieurs requêtes d'un même utilisateur.
- Pratique pour :
  - Authentification (garder l'utilisateur connecté)
  - Panier e-commerce
  - Messages flash

**Stocker une donnée en session :**

```php
$session = $request->getSession();
$session->set('username', 'Jean');
```

**Lire une donnée en session :**

```php
$username = $session->get('username');
```

**Détruire la session :**

```php
$session->invalidate();
```

---

# 4. 🍪 **Cookies**

## Qu'est-ce qu'un `Cookie` ?
- Un **cookie** est un petit fichier stocké sur l'ordinateur du client par le navigateur.
- Les cookies sont envoyés avec chaque requête HTTP.

**Créer un cookie en Symfony :**

```php
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

public function setCookie()
{
    $response = new Response();
    $cookie = Cookie::create('user_id', '12345')->withExpires(strtotime('tomorrow'));
    $response->headers->setCookie($cookie);
    $response->send();
}
```

**Lire un cookie :**

```php
$userId = $request->cookies->get('user_id');
```

---

# 5. ⚙️ **Request::isMethod()**

## Tester le type de requête

Symfony permet de savoir si la requête est de type **POST**, **GET**, etc.

**Exemple :**

```php
if ($request->isMethod('POST')) {
    // Traitement d'une requête POST
}

if ($request->isMethod('GET')) {
    // Traitement d'une requête GET
}
```

## **Pourquoi utiliser `isMethod()` ?**
- Pour un même contrôleur, accepter plusieurs méthodes HTTP.
- Par exemple, afficher un formulaire avec `GET` et le traiter avec `POST`.

---

# 🧠 **Résumé**

| Action                        | Méthode Symfony                         |
|-------------------------------|-----------------------------------------|
| Lire paramètre GET             | `$request->query->get('param')`         |
| Lire paramètre POST            | `$request->request->get('param')`       |
| Lire un cookie                 | `$request->cookies->get('cookie_name')` |
| Lire une session               | `$request->getSession()->get('key')`    |
| Écrire dans la session         | `$request->getSession()->set('key', $val)` |
| Tester si requête est POST     | `$request->isMethod('POST')`            |
| Tester si requête est GET      | `$request->isMethod('GET')`             |

---

# 🚀 **À pratiquer**

- Formulaire de contact avec `POST`.
- Système de recherche avec `GET`.
- Panier avec `Session`.
- Acceptation de cookies avec un `Cookie` personnalisé.

---

# 📚 **Documentation Officielle**

- [Symfony HTTP Foundation](https://symfony.com/doc/current/components/http_foundation.html)
- [Symfony Session](https://symfony.com/doc/current/session.html)
- [Symfony Cookies](https://symfony.com/doc/current/components/http_foundation/cookies.html)
