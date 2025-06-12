
# 🧠 Gestion des Cookies et de la Session en Symfony

## 📖 Différence entre Cookie et Session

| Cookies | Sessions |
|--------|----------|
| Stockés **côté client** (navigateur) | Stockés **côté serveur** |
| Limités en taille (~4KB) | Peut contenir plus de données |
| Accessibles via JavaScript (si non `HttpOnly`) | Inaccessibles via JS |
| Envoyés à chaque requête automatiquement | Identifiés par un cookie spécial (`PHPSESSID`) |
| Bons pour : thème, langue, consentement | Bons pour : utilisateur, panier, CSRF token |

---

## 🍪 Gestion des Cookies en Symfony

### Créer un Cookie :

```php
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

$response = new Response();
$cookie = Cookie::create('theme', 'dark', strtotime('+1 year'));
$response->headers->setCookie($cookie);
```

### Lire un Cookie :

```php
$theme = $request->cookies->get('theme', 'light');
```

### Supprimer un Cookie :

```php
$response->headers->clearCookie('theme');
```

### Exemple Complet :

```php
#[Route('/cookie', name: 'cookie_test')]
public function cookieTest(Request $request): Response
{
    $response = new Response();
    $theme = $request->cookies->get('theme', 'light');

    $response->headers->setCookie(
        Cookie::create('theme')->withValue('dark')->withExpires(strtotime('+1 year'))->withPath('/')
    );

    $response->setContent('Thème actuel : ' . $theme);
    return $response;
}
```

---

## 🧰 Gestion de la Session en Symfony

### Accéder à la session :

```php
$session = $request->getSession();
```

### Écrire une donnée :

```php
$session->set('nom', 'Jean');
```

### Lire une donnée :

```php
$nom = $session->get('nom', 'anonyme');
```

### Supprimer une donnée :

```php
$session->remove('nom');
```

### Voir toutes les données :

```php
dump($session->all());
```

### Exemple Complet :

```php
#[Route('/session', name: 'session_test')]
public function sessionTest(Request $request): Response
{
    $session = $request->getSession();
    $session->set('panier', ['article' => 'chaise', 'quantite' => 2]);
    $panier = $session->get('panier');

    return new Response('Panier : ' . json_encode($panier));
}
```

---

## 🔁 Cookie et Session ensemble

Quand Symfony utilise une session, il crée automatiquement un cookie `PHPSESSID` pour identifier l'utilisateur.

---

## ✅ Résumé Rapide

| Action | Cookie | Session |
|--------|--------|---------|
| Lire | `$request->cookies->get('clé')` | `$request->getSession()->get('clé')` |
| Écrire | `$response->headers->setCookie()` | `$request->getSession()->set()` |
| Supprimer | `$response->headers->clearCookie()` | `$request->getSession()->remove()` |
