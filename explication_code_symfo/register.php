<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

// Contrôleur responsable de l'inscription d'un nouvel utilisateur
class RegistrationController extends AbstractController
{
    // Route qui affiche et traite le formulaire d'inscription à l'URL "/inscription"
    #[Route('/inscription', name: 'inscription')]
    public function register(
        Request $request,                         // Représente la requête HTTP (GET, POST, etc.)
        UserPasswordHasherInterface $userPasswordHasher, // Service pour hasher le mot de passe
        EntityManagerInterface $entityManager     // Permet de sauvegarder les entités dans la base de données
    ): Response {
        // Création d'un nouvel utilisateur vide
        $user = new User();

        /**
         * Création du formulaire :
         * - `RegistrationForm::class` : classe qui définit la structure des champs du formulaire (dans src/Form)
         * - `$user` : l’objet auquel les champs du formulaire seront liés automatiquement (hydration)
         *
         * Symfony reliera automatiquement les champs du formulaire aux setters de l'objet User
         * Exemple : champ "email" => $user->setEmail()
         */
        $form = $this->createForm(RegistrationForm::class, $user);

        /**
         * Analyse la requête HTTP :
         * - Si c'est une requête POST : Symfony tente de remplir le formulaire avec les données envoyées
         * - Si c’est une requête GET : le formulaire reste vide (affichage simple)
         */
        $form->handleRequest($request);

        /**
         * Vérifie deux choses :
         * 1. Le formulaire a été soumis (via POST)
         * 2. Les champs remplis sont valides (selon les contraintes définies dans RegistrationForm)
         */
        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * Récupère la donnée du champ "plainPassword" (non mappé à l'entité User)
             * C’est un champ temporaire uniquement utilisé pour le hash
             */
            $plainPassword = $form->get('plainPassword')->getData();

            /**
             * Utilise le service de hachage pour chiffrer le mot de passe
             * Le mot de passe haché est ensuite stocké dans l'objet User
             */
            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            /**
             * Doctrine ORM :
             * - `persist()` prépare l’enregistrement de l’objet
             * - `flush()` exécute la requête SQL pour insérer l’objet en base
             */
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirection vers la page de connexion après l'inscription réussie
            return $this->redirectToRoute('login');
        }

        /**
         * Affichage du formulaire dans le template Twig s’il n’est pas encore soumis
         * ou s’il y a des erreurs de validation
         */
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form, // Transmet le formulaire à Twig pour l'affichage
        ]);
    }
}
