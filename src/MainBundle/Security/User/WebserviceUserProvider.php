<?php

// src/MainBundle/Security/User/WebserviceUserProvider.php
namespace MainBundle\Security\User;

use MainBundle\Security\User\WebserviceUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;


class WebserviceUserProvider implements UserProviderInterface
{ 
    /**
     * Crée un utilisateur avec pour premier attribut son email puis le renvoie
     * @param String $username
     * @return WebserviceUser
     */
    public function loadUserByUsername($username)
    {
        return new WebserviceUser($username);
    }
    
    /**
     * Fonction inconnue
     * @param UserInterface $user
     * @return WebserviceUser
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }
        return $this->loadUserByUsername($user->getUsername());
    }
    
    /**
     * Fonction inconnue
     * @param type $class
     * @return type
     */
    public function supportsClass($class)
    {
        return WebserviceUser::class === $class;
    }
}

