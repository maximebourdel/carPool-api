<?php 

// src/MainBundle/Security/User/WebserviceUser.php
namespace MainBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

class WebserviceUser implements EquatableInterface, JWTUserInterface
{
    private $username;
    private $password;
    private $salt;
    private $roles;
    private $nom;
    private $prenom;

    public function __construct($username, array $roles=null )
    {
        $this->username = $username;
        $this->roles = $roles;
    }

    /**
     * Retourne le Role d'un utilisateur
     * @return Array de roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Définis les roles d'un utilisateur
     * @param Array de roles $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Retourne le password d'un utilisateur
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Définit le role d'un utilisateur
     * @param String $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }    

    /**
     * Définit le grain de sable du password de l'utilisateur
     * @param String $salt
     * @return String
     */
    public function setSalt($salt)
    {
        return $this->salt = $salt;
    }
    
    /**
     * Définit le grain de sable du password de l'utilisateur
     * @return String
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Retourne le username (email) de l'utilisateur
     * @return String
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Définit le nom de famille d'un utilisateur
     * @param String $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }       
    
    /**
     * Retourne le nom de famille d'un utilisateur
     * @return String
     */
    public function getNom()
    {
        return $this->nom;
    }
    
    /**
     * Définit le prénom d'un utilisateur
     * @param String $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
    
    /**
     * Retourne le prénom d'un utilisateur
     * @return String
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Fonction non utilisée
     */
    public function eraseCredentials(){}

    /**
     * Va créer l'utilisateur
     * @param String $username email de l'utilisateur
     * @param array $payload (nom et prénom de l'tilisateur)
     * @return \self
     */
    public static function createFromPayload($username, array $payload)
    {
        //Cas ou l'utilisateur se login
        if (isset($payload['roles'])) {
            return new self($username, $payload['roles']);
        //Cas ou l'utilisateur à déjà son token
        } else {
            return new self($username);
        }
    }
    

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            return false;
        }
        
        if ($this->roles !== $user->getRoles()) {
            return false;
        }
        
        if ($this->username !== $user->getUsername()) {
            return false;
        }
        return true;
    }
}
