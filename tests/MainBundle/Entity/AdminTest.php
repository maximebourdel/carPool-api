<?php

namespace Test\MainBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use MainBundle\Entity\Admin;

class AdminTest extends WebTestCase
{      
    public function testGetId() {
        $admin = new Admin();
        $this->assertEquals(null, $admin->getId());
    }
    
    public function testSetEmail() {
        $admin = new Admin();
        $admin->setEmail('maxime.bourdel@businessdecision.com');
        $this->assertAttributeEquals(
            'maxime.bourdel@businessdecision.com'
            , 'email'
            , $admin
        );
    }
    
    public function testgetEmail() {
        $admin = new Admin();
        $admin->setEmail('maxime.bourdel@businessdecision.com');
        $this->assertEquals('maxime.bourdel@businessdecision.com'
            , $admin->getEmail()
        );
    }
}
