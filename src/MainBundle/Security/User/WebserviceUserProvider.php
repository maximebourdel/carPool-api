<?php

// src/MainBundle/Security/User/WebserviceUserProvider.php
namespace MainBundle\Security\User;

use MainBundle\Security\User\WebserviceUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class WebserviceUserProvider implements UserProviderInterface
{ 

	private $request;
	private $container;


    /**
    * @param ContainerInterface $container The service container instance
    */
    public function __construct(Container $container)
    {
		$this->container = $container;
        $request = $container->get('request_stack')->getMasterRequest();
		
		$this->request = $request;
    }

    public function loadUserByUsername($username)
    {
		//On récupère le mot de passe entré par l'utilisateur
		$password = $this->request->request->get('password');
    
		
		$url='https://www.kayoo.com/_/Layout_Common_Login/login2';

		//Paramètres POST pour Kayoo
		$values= 'user='.$username;
		$values.= '&password='.$password;
		$values.= '&rememberMe=true';
		$values.= '&json=true';


		//Appel à l'API Kayoo
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$values);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response  = curl_exec($ch);
		curl_close ($ch);
		
		$json_response = json_decode($response, true); 

		if( $json_response['error'] == "0"){

			return new WebserviceUser(
				$username, $password, '', [ 'ROLE_USER' ]
				, $json_response['usr_info']['last_name']
				, $json_response['usr_info']['first_name']
			);
		}

        throw new UsernameNotFoundException(
            sprintf('Utilisateur "%s" non existant sur Kayoo.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return WebserviceUser::class === $class;
    }
}

