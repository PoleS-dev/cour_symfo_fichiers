
# ⚡ Symfony : Session vs Cookies

---

## 🧭 Qu'est-ce qu'une Session ?

- **Session** = **Stockage serveur**.
- Associe un identifiant de session (`session_id`) à un utilisateur.
- Le serveur conserve les données (fichiers, base de données, Redis).
- Le navigateur n'a qu'un cookie de session qui contient **seulement l'identifiant**.

**Utilisation typique :**
- Authentification utilisateur.
- Panier d'achat.
- Messages flash.

---

## 🧁 Qu'est-ce qu'un Cookie ?

- **Cookie** = **Stockage client** (navigateur).
- Petites données envoyées avec chaque requête HTTP.
- Visible, modifiable côté client.
- Limité en taille (~4 KB).

**Utilisation typique :**
- Préférences utilisateur (langue, thème).
- Consentement RGPD.
- Authentification persistante ("Remember me").

---

# 🎯 Que recommande Symfony ?

| Utilisation de la Session          | Utilisation des Cookies            |
|------------------------------------|------------------------------------|
| Données sensibles/confidentielles  | Préférences utilisateur simples   |
| Authentification                   | Consentement, choix d’UI           |
| Stockage volumineux (panier)        | Stockage léger (~4 KB)             |
| **Plus sécurisé**                  | **Moins sécurisé**                 |

✅ **Symfony recommande** :
- **Session** ➔ pour données **sécurisées** (authentification, panier).
- **Cookies** ➔ pour **préférences simples** (langue, consentement).

---

# 🛡️ Pourquoi Symfony favorise la Session ?

- **Invisible** pour l'utilisateur.
- Les données sensibles **ne transitent pas** dans les requêtes.
- Moins de risques de vol ou d'altération.
- Plus **sécurisé** pour la gestion des utilisateurs connectés.

---

# 🧠 Résumé rapide

| Caractéristique                      | Session                          | Cookie                         |
|--------------------------------------|----------------------------------|--------------------------------|
| Stockage                             | Serveur                          | Client (navigateur)            |
| Taille maximale                      | Illimitée (dépend du backend)     | 4KB environ                    |
| Sécurité                             | Très sécurisé                    | Moins sécurisé                 |
| Accessibilité                        | Invisible pour l'utilisateur     | Accessible depuis le navigateur |
| Exemples                             | Authentification, Panier         | Langue, Thème, Consentement    |

---

# 🚀 Conclusion

Symfony recommande :
- **Session** : Données sensibles et confidentielles.
- **Cookies** : Petites données non sensibles.

Ils sont **complémentaires** selon les besoins spécifiques d'une application.

---

# 📚 Documentation Officielle

- [Symfony Sessions](https://symfony.com/doc/current/session.html)
- [Symfony HTTP Cookies](https://symfony.com/doc/current/components/http_foundation/cookies.html)
