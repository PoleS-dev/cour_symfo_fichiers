# Commandes utiles Symfony – Récapitulatif

---

## 🏗️ GÉNÉRATION DE BASE

```bash
symfony new nom_projet --webapp         # Créer un projet Symfony complet
symfony serve                           # Démarrer le serveur local
symfony serve -d                        # Démarrer le serveur en arrière-plan
symfony open:local                      # Ouvre l'application dans le navigateur
symfony check:requirements              # Vérifier la configuration système
```

---

## 🧰 CONSOLE SYMFONY

```bash
php bin/console                         # Afficher toutes les commandes disponibles
php bin/console debug:router           # Lister les routes
php bin/console debug:container        # Lister les services
php bin/console cache:clear            # Vider le cache
php bin/console --version              # Voir la version de Symfony
```

---

## ⚙️ GÉNÉRATION DE CODE

```bash
php bin/console make:controller NomController    # Créer un contrôleur
php bin/console make:entity                      # Créer une entité
php bin/console make:migration                   # Générer une migration
php bin/console doctrine:migrations:migrate      # Appliquer les migrations
php bin/console make:form NomType                # Créer un formulaire
php bin/console make:auth                        # Créer un système de login
php bin/console make:security:form-login         # Créer un formulaire de login
php bin/console make:user                        # Créer un utilisateur
php bin/console make:crud Nom                    # Interface CRUD complète
```

---

## 🗃️ DOCTRINE

```bash
php bin/console doctrine:database:create         # Créer la base de données
php bin/console doctrine:mapping:info            # Voir les entités disponibles
php bin/console doctrine:schema:update --force   # Mettre à jour le schéma (attention en prod)
php bin/console doctrine:query:sql 'SELECT * FROM user'   # Exécuter une requête SQL
php bin/console doctrine:database:drop --force   # Supprimer la base de données (⚠️ destructif)
```

---

## 🔐 SÉCURITÉ

```bash
php bin/console make:auth                        # Créer un authenticator
php bin/console make:user                        # Créer un utilisateur
php bin/console make:controller SecurityController  # Créer un contrôleur de login
```

---

## 🛠️ DIVERS & DEBUG

```bash
# Créer un service : Créer une classe dans src/Service/
php bin/console list                              # Lister toutes les commandes disponibles
php bin/console debug:container App\Service\TonService  # Voir la config d’un service
php bin/console debug:router                      # Voir toutes les routes disponibles
php bin/console doctrine:query:sql 'SELECT NOW()' # Tester la connexion à la base
```
