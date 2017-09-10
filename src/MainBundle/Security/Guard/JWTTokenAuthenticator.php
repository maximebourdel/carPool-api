<?php

namespace MainBundle\Security\Guard;

use MainBundle\Entity\Admin;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseAuthenticator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class JWTTokenAuthenticator extends BaseAuthenticator
{
    private $doctrine;
    
    /**
     * Injecte doctrine via les services
     * @param type $doctrine
     */
    public function setDoctrine($doctrine){
        $this->doctrine = $doctrine;
    }
    
    /**
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
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['username'];
        return $userProvider->loadUserByUsername($username);
    }
    

    /**
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
                $admin = $this->doctrine->getRepository('MainBundle:Admin')
                            ->findOneByEmail($user->getUsername());
                
                //Si il est dans la base c'est un admin sinon alors USER
                if($admin != null ){
                    $user->setRoles(['ROLE_ADMIN']);
                } else {
                    $user->setRoles(['ROLE_USER']);
                }
                
                return true;
        }
        
        throw new BadCredentialsException();
    }
    
    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException If there is no pre-authenticated token previously stored
     */
    public function createAuthenticatedToken(UserInterface $user, $providerKey)
    {
        return new JWTUserToken(['ROLE_USER'], $user);
    }
    
    
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
