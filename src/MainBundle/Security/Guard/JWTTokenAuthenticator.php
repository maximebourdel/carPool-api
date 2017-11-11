<?php

namespace MainBundle\Security\Guard;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseAuthenticator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * Représente tous les appels concernant l'identification d'un utilisateur (login)
 * @package MainBundle\Security\Guard
 * @author Maxime Bourdel
 */
class JWTTokenAuthenticator extends BaseAuthenticator
{
    private $doctrines;
    
    /**
     * Injecte doctrine via les services
     * @param type $doctrine
     */
    public function setDoctrine($doctrine){
        $this->doctrines = $doctrine;
    }
    
    /**
     * Etape 1 
     * Récupère ce que rentre l'utilisateur et le retourne sous forme de tableau
     * @param Request $request
     * @throws \InvalidArgumentException
     * @return Array
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        
        if ($username == null || $password == null){
            throw new \InvalidArgumentException('Merci de renseigner les paramètres d\'authentification');
        }
        
        return array(
            'username' => $username,
            'password' => $password
        );
    }

    /**
     * Etape 2
     * Récupère l'utilisateur
     * @param type $credentials
     * @param UserProviderInterface $userProvider
     * @return type
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['username'];
        return $userProvider->loadUserByUsername($username);
    }

    /**
     * Etape 3
     * Vérifie le mot de passe (password) de l'utilisateur est correct via l'API Kayoo
     * @param type $credentials
     * @param UserInterface $user
     * @return boolean return true si mdp ok
     * @throws BadCredentialsException
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        //Paramètres POST pour Kayoo
        $values= 'user='.$user->getUserName();
        $values.= '&password='.$credentials['password'];
        $values.= '&rememberMe=true';
        $values.= '&json=true';
        
        $json_response = $this->callKayooAPI($values);

        if( $json_response['error'] == '0'){
            $user->setPassword($credentials['password']);
            $user->setNom($json_response['usr_info']['last_name']);
            $user->setPrenom($json_response['usr_info']['first_name']);

            //On recherche si il y a un admin de répertorié
            $admin = $this->doctrines->getRepository('MainBundle:Admin')
                        ->findOneByEmail($user->getUsername());

            //Si il est dans la base c'est un admin sinon alors USER
            if($admin != null ){
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }
            //Arrivé ici = mdp ok donc on valide cette étape
            return true;
        }
        
        //Mauvaises authentification (email ou mdp)
        throw new BadCredentialsException();
    }
    
    /**
     * Etape 4
     * L'utilisateur est OK, on crée son token
     * @param UserInterface $user
     * @param type $providerKey
     * @return JWTUserToken
     * {@inheritdoc}
     */
    public function createAuthenticatedToken(UserInterface $user, $providerKey)
    {
        return new JWTUserToken(['ROLE_USER'], $user);
    }
    
    /**
     * Appel à l'API Kayoo
     * @param type $values valeurs en GET (ex : https://www.kayoo.com/_/Layout_Common_Login/login2?user=maxime.bourdel@businessdecision.com&password=toto&rememberMe=true&json=true)
     * @return type json exemple en cas d'erreur {"error":800,"message":"Identifiant ou mot de passe incorrect","app_info":{"v":{"web_app":"1.7.20160307","mobile_app":"3.0"}}}
     */
    private function callKayooAPI($values){
        
        $url='https://www.kayoo.com/_/Layout_Common_Login/login2';
        
        //Appel à l'API Kayoo
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $values);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close ($ch);
        
        return json_decode($response, true);
    }
}
