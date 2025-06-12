<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Entité User : représente un utilisateur dans la base de données
 * 
 * - Chaque propriété correspond à une colonne en base
 * - L'entité implémente UserInterface pour la sécurité Symfony
 * - UniqueEntity empêche les doublons (ici, sur le username)
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * Identifiant unique auto-incrémenté
     * 
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Nom d'utilisateur (doit être unique)
     * 
     * @var string|null
     */
    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * Liste des rôles de l'utilisateur (ROLE_USER, ROLE_ADMIN, etc.)
     * 
     * @var string[]
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * Mot de passe haché (jamais stocké en clair)
     * 
     * @var string|null
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * Email de l'utilisateur
     * 
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * Adresse postale
     * 
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    /**
     * Numéro de téléphone
     * 
     * @var string|null
     */
    #[ORM\Column(length: 30)]
    private ?string $telephone = null;

    /**
     * Nom du fichier image (photo de profil)
     * 
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * Mot de passe temporaire non mappé (plainPassword)
     * Utilisé uniquement lors de la création ou modification du mot de passe
     * 
     * @var string|null
     */
    private ?string $plainPassword = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Identifiant visuel de l'utilisateur (souvent le username)
     * 
     * @see UserInterface
     */
    /**
     * Identifiant unique de l'utilisateur pour Symfony (utilisé pour l'authentification).
     * Ce champ remplace l'ancienne méthode getUsername() depuis Symfony 5.3.
     * En général, on retourne l'email ou le nom d'utilisateur.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        // On retourne ici le champ "username" comme identifiant de connexion
        return (string) \$this->username;
    }

    /**
     * Retourne les rôles de l'utilisateur avec ROLE_USER garanti
     * 
     * @see UserInterface
     * @return string[]
     */
    /**
     * Retourne la liste des rôles de l'utilisateur.
     *
     * Par défaut, Symfony utilise le rôle ROLE_USER comme niveau minimum.
     * On s'assure donc ici que ce rôle est toujours présent même si l'utilisateur
     * n'a aucun rôle défini explicitement (sinon Symfony pourrait refuser l'accès).
     *
     * @see UserInterface
     * @return string[]
     */
    public function getRoles(): array
    {
        \$roles = \$this->roles;

        // ROLE_USER est ajouté automatiquement s'il n'existe pas déjà
        \$roles[] = 'ROLE_USER';

        // array_unique() empêche les doublons (utile si ROLE_USER est déjà présent)
        return array_unique(\$roles);
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Efface les données sensibles temporaires, appelé après l'authentification
     * 
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }
}


// see et var 
// Indique le type attendu pour l’attribut.

// Très utile pour les IDE (comme PHPStorm, VS Code) : autocomplétion, surlignage d’erreur, etc.

// Pas obligatoire mais très recommandé, surtout quand le type est ambigu ou pour les tableaux.
