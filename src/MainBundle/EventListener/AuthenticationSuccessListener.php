<?php

// src/MainBundle/EventListener/AuthenticationSuccessListener.php
namespace MainBundle\EventListener;


use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use MainBundle\Security\User\WebserviceUser;

//A supprimer
class AuthenticationSuccessListener 
{
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof WebserviceUser) {
            return;
        }
        //Possibilité d'ajouter de la data dans le payload mais l'idéal est dans la classe JWTCreatedListener.php
        /*$data['user_values'] = array(
            'email' => $user->getUsername(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
        );*/

        $event->setData($data);
    }
}
