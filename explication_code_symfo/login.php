<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Contrôleur de sécurité responsable de la gestion de la connexion et déconnexion.
 */
class SecurityController extends AbstractController
{
    /**
     * Affiche le formulaire de connexion et gère les erreurs d'identification.
     *
     * @param AuthenticationUtils \$authenticationUtils Utilitaire Symfony pour récupérer les erreurs de login
     * @return Response
     */
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils \$authenticationUtils): Response
    {
        // Récupère l'erreur d'authentification s'il y en a une (ex : mauvais mot de passe)
        \$error = \$authenticationUtils->getLastAuthenticationError();

        // Récupère le dernier nom d'utilisateur saisi dans le formulaire
        \$lastUsername = \$authenticationUtils->getLastUsername();

        // Envoie ces données au template Twig pour afficher l'erreur et le nom prérempli
        return \$this->render('security/login.html.twig', [
            'last_username' => \$lastUsername,
            'error' => \$error,
        ]);
    }

    /**
     * Route de déconnexion : Symfony intercepte cette méthode automatiquement.
     * Tu n'as pas besoin de l'implémenter.
     *
     * @throws \LogicException
     */
    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        // Symfony intercepte cette méthode automatiquement via le firewall "logout"
        // Voir config/packages/security.yaml -> section "logout"
        throw new \LogicException('Cette méthode est vide car interceptée automatiquement par le firewall de sécurité.');
    }
}


// $authenticationUtils est un objet instancié par Symfony via l’injection de dépendance automatique.
// Symfony voit que tu demandes un objet de type AuthenticationUtils, donc il :

// le crée (s’il n’existe pas encore) ;

// te l’injecte dans la méthode login() au moment où elle est appelée.

// C’est ce qu’on appelle l'injection de dépendance via les arguments de méthode.

// ✅ Ce que tu fais réellement
// Tu déclares un paramètre typé dans la méthode.

// Symfony reconnaît le type, le fournit automatiquement, et tu l’utilises directement.

// Tu n’as jamais besoin d’écrire :

// php
// Copier
// Modifier
// $authenticationUtils = new AuthenticationUtils(...);
