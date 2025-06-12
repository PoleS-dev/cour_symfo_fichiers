# Symfony - Base des Formulaires

Symfony fournit un système de formulaire puissant, flexible et bien intégré avec Doctrine et Twig.

---

## 1️⃣ CRÉER UN FORMULAIRE

```bash
php bin/console make:form
```

> Exemple : `ProductType` lié à `App\Entity\Product`  
> Symfony générera un fichier `ProductType.php` dans le dossier `src/Form/`.

---

## 2️⃣ EXEMPLE DE FORMULAIRE AVEC BUILDER

```php
// src/Form/ProductType.php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'attr' => [
                    'placeholder' => 'Entrez le nom',
                    'class' => 'form-control'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR',
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
```

### 🧠 Détail du Builder :

- `add()` : ajoute un champ au formulaire
- `TextType`, `MoneyType` : types de champ prédéfinis (texte, argent, etc.)
- `label` : personnalise l’étiquette affichée
- `attr` : permet d’ajouter des attributs HTML (comme `class`, `placeholder`…)

---

## 3️⃣ UTILISER LE FORMULAIRE DANS UN CONTRÔLEUR

```php
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;

public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $product = new Product();
    $form = $this->createForm(ProductType::class, $product);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('product_success');
    }

    return $this->render('product/new.html.twig', [
        'form' => $form->createView(),
    ]);
}
```

---

## 4️⃣ AFFICHER LE FORMULAIRE DANS TWIG

```twig
{# templates/product/new.html.twig #}

<h1>Créer un produit</h1>

{{ form_start(form) }}
    <div class="form-group">
        {{ form_label(form.name) }}
        {{ form_widget(form.name) }}
        {{ form_errors(form.name) }}
    </div>

    <div class="form-group">
        {{ form_label(form.price) }}
        {{ form_widget(form.price) }}
        {{ form_errors(form.price) }}
    </div>

    <button class="btn btn-primary">Envoyer</button>
{{ form_end(form) }}
```

---

## 🎨 PERSONNALISER LE STYLE AVEC CSS (ex. Bootstrap)

Symfony génère des balises HTML que vous pouvez styliser :

- Utilisez l’attribut `attr` dans le builder pour ajouter des classes CSS (`'class' => 'form-control'`)
- Dans Twig, enrobez chaque champ dans une `div.form-group` pour Bootstrap
- Ajoutez des classes aux boutons avec `<button class="btn btn-primary">`

---

## 🧩 CONSEILS SUPPLÉMENTAIRES

- Utilisez `{{ form_row(form.field) }}` pour un champ complet (label + input + erreurs)
- Pour afficher chaque partie séparément : `form_label()`, `form_widget()`, `form_errors()`
- Vous pouvez créer des formulaires non liés à une entité (`'data_class' => null`)
- Pour des champs dynamiques (liste déroulante, checkbox, etc.), explorez les autres `FormType` : `ChoiceType`, `CheckboxType`, `CollectionType`, etc.

---

## ✅ Résumé

✔ Commande : `make:form`  
✔ Builder : `add()` pour chaque champ  
✔ Twig : `form_start()`, `form_widget()`, `form_end()`  
✔ CSS : via `attr` ou en stylisant les balises dans le template  
✔ Entités automatiquement liées et sauvegardées via `handleRequest()` + `isSubmitted()`

---

## 📚 Documentation utile

- [Symfony Forms](https://symfony.com/doc/current/forms.html)
- [Form Field Types](https://symfony.com/doc/current/reference/forms/types.html)
