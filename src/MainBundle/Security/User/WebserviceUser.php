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

    public function __construct($username, array $roles=null )
    {
        $this->username = $username;
        $this->roles = $roles;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }    

    public function setSalt($salt)
    {
        return $this->salt = $salt;
    }
    
    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }       
    
    public function getNom()
    {
        return $this->nom;
    }
    
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
    
    public function getPrenom()
    {
        return $this->prenom;
    }

    public function eraseCredentials()
    {
    }

    public static function createFromPayload($username, array $payload)
    {
        if (isset($payload['roles'])) {
            return new self($username, $payload['roles']);
        } else {
            return new self($username);
        }
	
    }
    

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}
