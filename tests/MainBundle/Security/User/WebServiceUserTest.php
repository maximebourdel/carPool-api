<?php

namespace Test\MainBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use MainBundle\Security\User\WebserviceUser;
use Symfony\Bridge\Doctrine\Tests\Fixtures\User;


class WebServiceUserTest extends WebTestCase
{    
    public function testSetRoles() {
        $webServiceUser = new WebServiceUser(
            'maxime.bourdel@businessdecision.com'
            , ['ROLE_USER']
        );
        $webServiceUser->setRoles(['ROLE_ADMIN']);
        $this->assertAttributeEquals(['ROLE_ADMIN'], 'roles', $webServiceUser);
    }
    
    public function testgetRoles() {
        $webServiceUser = new WebServiceUser(
            'maxime.bourdel@businessdecision.com'
            , ['ROLE_USER']
        );
        $webServiceUser->setRoles(['ROLE_USER']);
        $this->assertEquals(['ROLE_USER'], $webServiceUser->getRoles());
    }
    
    public function testSetPassword() {
        $webServiceUser = new WebServiceUser(
            'maxime.bourdel@businessdecision.com'
            , ['ROLE_USER']
        );
        $webServiceUser->setPassword('motDePasse');
        $this->assertAttributeEquals('motDePasse', 'password', $webServiceUser);
    }
    
    public function testgetPassword() {
        $webServiceUser = new WebServiceUser(
            'maxime.bourdel@businessdecision.com'
            , ['ROLE_USER']
        );
        $webServiceUser->setPassword('motDePasse');
        $this->assertEquals('motDePasse', $webServiceUser->getPassword());
    }
    
    public function testSetSalt() {
        $webServiceUser = new WebServiceUser(
            'maxime.bourdel@businessdecision.com'
            , ['ROLE_USER']
        );
        $webServiceUser->setSalt('azerty');
        $this->assertAttributeEquals('azerty', 'salt', $webServiceUser);
    }
    
    public function testgetSalt() {
        $webServiceUser = new WebServiceUser(
            'maxime.bourdel@businessdecision.com'
            , ['ROLE_USER']
        );
        $webServiceUser->setSalt('azerty');
        $this->assertEquals('azerty', $webServiceUser->getSalt());
    }
    
    public function testgetUsername() {
        $webServiceUser = new WebServiceUser(
            'maxime.bourdel@businessdecision.com'
            , ['ROLE_USER']
        );
        $this->assertEquals('maxime.bourdel@businessdecision.com', $webServiceUser->getUsername());
    }
    
    public function testSetNom() {
        $webServiceUser = new WebServiceUser(
            'maxime.bourdel@businessdecision.com'
            , ['ROLE_USER']
        );
        $webServiceUser->setNom('BOURDEL');
        $this->assertAttributeEquals('BOURDEL', 'nom', $webServiceUser);
    }
    
    public function testgetNom() {
        $webServiceUser = new WebServiceUser(
            'maxime.bourdel@businessdecision.com'
            , ['ROLE_USER']
        );
        $webServiceUser->setNom('BOURDEL');
        $this->assertEquals('BOURDEL', $webServiceUser->getNom());
    }
    
    public function testSetPrenom() {
        $webServiceUser = new WebServiceUser(
            'maxime.bourdel@businessdecision.com'
            , ['ROLE_USER']
        );
        $webServiceUser->setPrenom('Maxime');
        $this->assertAttributeEquals('Maxime', 'prenom', $webServiceUser);
    }
    
    public function testgetPrenom() {
        $webServiceUser = new WebServiceUser(
            'maxime.bourdel@businessdecision.com'
            , ['ROLE_USER']
        );
        $webServiceUser->setPrenom('Maxime');
        $this->assertEquals('Maxime', $webServiceUser->getPrenom());
    }
    
    public function testCreateFromPayload() {
        $payload = array('username' => 'maxime.bourdel@businessdecision.com');
        
        $webServiceUser = WebserviceUser::createFromPayload(
                'maxime.bourdel@businessdecision.com'
               , $payload
        );
        
        $this->assertEquals(
            'maxime.bourdel@businessdecision.com'
            , $webServiceUser->getUsername()
        );
        
        $payload['roles'] = ['ROLE_USER'];
        $webServiceUser2 = WebserviceUser::createFromPayload(
            'maxime.bourdel@businessdecision.com'
            , $payload
        );
        $this->assertEquals(['ROLE_USER'], $webServiceUser2->getRoles());
    }
    
    public function testIsEqualTo() {
        
        $payloadRef = array(
             'username' => 'maxime.bourdel@businessdecision.com'
            , 'roles' => ['ROLE_USER']
            , 'password' => 'motDePasse'
            , 'salt' => 'azerty'
            , 'nom' => 'BOURDEL'
            , 'prenom' => 'Maxime'
        );
        
        $webServiceUserRef = WebserviceUser::createFromPayload(
            'maxime.bourdel@businessdecision.com'
            , $payloadRef
        );
        
        //Test instance differente
        $user = new User(1, 2, 'test');
        $this->assertFalse($webServiceUserRef->isEqualTo($user));
        
        //Test username different
        $webServiceUser2 = WebserviceUser::createFromPayload(
           'autre.personnebourdel@businessdecision.com'
            , $payloadRef
        );
        $this->assertFalse($webServiceUserRef->isEqualTo($webServiceUser2));
        
        $webServiceUser3 = WebserviceUser::createFromPayload(
            'maxime.bourdel@businessdecision.com'
            , array()
        );
        //Test role faux
        $this->assertFalse($webServiceUserRef->isEqualTo($webServiceUser3));
        //Ajout du role
        $webServiceUser3->setRoles(['ROLE_USER']);
        //Doit etre ok maintenenat
        $this->assertTrue($webServiceUserRef->isEqualTo($webServiceUser3));
       
    }
}
