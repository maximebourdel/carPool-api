<?php
// src/AppBundle/EventListener/JWTCreatedListener.php

namespace MainBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * JWTCreatedListener
 *
 * @package MainBundle\EventListener
 * @author Maxime Bourdel
 */
class JWTCreatedListener
{

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * Renvoie les différents payloads pour le token JWT
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $user=$event->getUser();
        //Contient déjà l'email
        $payload       = $event->getData();
        //On y rajoute le nom et le prénom
        $payload['nom'] = $user->getNom();
        $payload['prenom'] = $user->getPrenom();

        $event->setData($payload);
    }
}
