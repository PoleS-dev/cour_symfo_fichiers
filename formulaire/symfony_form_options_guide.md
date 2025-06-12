# 📝 Guide des options des champs de formulaire Symfony

Symfony fournit une API puissante et souple pour créer des formulaires avec validation intégrée. Ce guide explique les options disponibles dans la méthode `add()` d’un `FormType`.

---

## 🧱 Exemple de formulaire d'inscription utilisateur

```php
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Adresse email',
                'required' => true,
                'attr' => ['placeholder' => 'exemple@domaine.com'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(['message' => 'Adresse email invalide.']),
                ],
                'help' => 'Utilisez une adresse valide.',
            ]);
    }
}
```

---

## ⚙️ Options possibles pour chaque champ

| Option         | Description |
|----------------|-------------|
| `label`        | Texte du label du champ (ex: `"Nom complet"`) |
| `required`     | `true/false` – Définit si le champ est obligatoire |
| `attr`         | Attributs HTML pour le champ (`placeholder`, `maxlength`, `class`, etc.) |
| `label_attr`   | Attributs HTML appliqués au label |
| `row_attr`     | Attributs HTML appliqués au conteneur du champ |
| `mapped`       | `true/false` – Champ lié ou non à l'entité |
| `constraints`  | Tableau de contraintes Symfony (voir plus bas) |
| `help`         | Texte d’aide affiché sous le champ |
| `data`         | Valeur initiale du champ |
| `empty_data`   | Valeur par défaut si aucun input n’est donné |

---

## ✅ Contraintes de validation disponibles

### 🔒 Contraintes classiques (`Symfony\Component\Validator\Constraints`)

| Contrainte    | Description |
|---------------|-------------|
| `NotBlank`    | Le champ ne doit pas être vide |
| `Length`      | Définir une longueur minimale et/ou maximale |
| `Email`       | Valide le format d’une adresse email |
| `Regex`       | Valide avec une expression régulière |
| `Choice`      | La valeur doit appartenir à une liste définie |
| `IsTrue` / `IsFalse` | Pour les cases à cocher (par exemple accepter les CGU) |
| `Url`         | Vérifie que la valeur est une URL |
| `EqualTo` / `NotEqualTo` | Comparaison avec une autre valeur |
| `Callback`    | Définir une logique de validation personnalisée en PHP |

---

## 📌 Exemple avec plusieurs options et contraintes

```php
$builder->add('username', TextType::class, [
    'label' => 'Nom d’utilisateur',
    'required' => true,
    'attr' => ['placeholder' => 'Votre pseudo', 'maxlength' => 20],
    'label_attr' => ['class' => 'form-label'],
    'row_attr' => ['class' => 'form-group'],
    'constraints' => [
        new Assert\NotBlank(['message' => 'Le pseudo est requis.']),
        new Assert\Length([
            'min' => 3,
            'max' => 20,
            'minMessage' => 'Trop court.',
            'maxMessage' => 'Trop long.',
        ]),
    ],
    'help' => '3 à 20 caractères.',
]);
```

---

## 🧠 Astuce : désactiver le mapping

Pour des champs comme "conditions d'utilisation", vous pouvez utiliser :

```php
->add('agreeTerms', CheckboxType::class, [
    'mapped' => false,
    'constraints' => [new Assert\IsTrue(['message' => 'Vous devez accepter.'])]
])
```

---

## 🔗 Ressources utiles

- [Form Types Symfony](https://symfony.com/doc/current/forms.html)
- [Contraintes de validation Symfony](https://symfony.com/doc/current/validation.html)

---
