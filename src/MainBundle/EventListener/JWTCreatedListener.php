<?php
// src/AppBundle/EventListener/JWTCreatedListener.php

namespace MainBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

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
     * Rencoie les différents payloads pour le token JWT
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $user=$event->getUser();
        
        $payload       = $event->getData();
        $payload['nom'] = $user->getNom();
        $payload['prenom'] = $user->getPrenom();

        $event->setData($payload);
    }
}
