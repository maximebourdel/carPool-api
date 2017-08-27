<?php

// src/MainBundle/EventListener/AuthenticationSuccessListener.php
namespace MainBundle\EventListener;


use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use MainBundle\Security\User\WebserviceUser;

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

		$data['user_values'] = array(
			'email' => $user->getUsername(),
			'nom' => $user->getNom(),
		    'prenom' => $user->getPrenom(),
		);

		$event->setData($data);
	}
}
