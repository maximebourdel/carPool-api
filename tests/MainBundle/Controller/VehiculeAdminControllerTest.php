<?php

namespace Tests\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VehiculeAdminControllerTest extends WebTestCase
{
    public function testGetVehiculeAllAction()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/vehicule/all');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
        
    }
}
