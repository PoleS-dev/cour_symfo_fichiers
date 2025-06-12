<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Formulaire d'inscription utilisateur.
 * 
 * Cette classe définit les champs du formulaire ainsi que les contraintes de validation.
 *
 * OPTIONS POSSIBLES POUR CHAQUE CHAMP (dans la méthode add):
 * - label : personnaliser le texte du label (ex : 'Nom complet')
 * - required : true/false pour rendre le champ obligatoire ou non
 * - attr : tableau des attributs HTML (ex : placeholder, class, maxlength...)
 * - label_attr : attributs HTML appliqués au label
 * - row_attr : attributs HTML appliqués au conteneur du champ
 * - mapped : true/false (indique si le champ est lié à l'entité)
 * - constraints : tableau de contraintes de validation (voir ci-dessous)
 * - help : texte d'aide affiché sous le champ
 * - data : valeur préremplie
 * - empty_data : valeur par défaut si rien n'est saisi
 *
 * CONTRAINTES POSSIBLES (Symfony\Component\Validator\Constraints):
 * - NotBlank : le champ ne doit pas être vide
 * - Length : définir une longueur min/max (avec messages personnalisés)
 * - Email : vérifier le format email
 * - Regex : valider selon un motif regex (ex : chiffres uniquement)
 * - Choice : la valeur doit faire partie d'une liste définie
 * - IsTrue / IsFalse : spécialement pour les cases à cocher
 * - Url : vérifier un format d'URL
 * - EqualTo / NotEqualTo : vérifier que la valeur est (ou n'est pas) égale à une autre
 * - Callback : logique de validation personnalisée (via une fonction)
 */
class RegistrationForm extends AbstractType
{
    /**
     * Construit le formulaire avec les champs désirés.
     * 
     * @param FormBuilderInterface \$builder Outil de construction du formulaire Symfony
     * @param array \$options Options passées au formulaire
     */
    public function buildForm(FormBuilderInterface \$builder, array \$options): void
    {
        \$builder
            ->add('email', EmailType::class)
            ->add('telephone')
            ->add('adresse', TextType::class)
            ->add('username')

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions générales.',
                    ]),
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit faire au moins {{ limit }} caractères.',
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    /**
     * Configure les options par défaut du formulaire.
     *
     * Ici, on lie le formulaire à l'entité `User`, ce qui signifie :
     * - Symfony va automatiquement instancier un objet `User` s’il n'est pas fourni
     * - Les champs du formulaire vont remplir les propriétés de l’objet `User`
     * - Les contraintes de validation (ex : @Assert\NotBlank) définies dans l’entité seront utilisées
     *
     * L’option `data_class` rend le formulaire intelligent et connecté à Doctrine (ORM).
     *
     * @param OptionsResolver \$resolver Le configurateur d'options Symfony
     */
    public function configureOptions(OptionsResolver \$resolver): void
    {
        \$resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
