<?php

// tests/MainBundle/Repository/VehiculeRepositoryTest.php
namespace Tests\MainBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test du respository Vehicule
 *
 * @author Maxime Bourdel
 */
class VehiculeRepositoryTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $client = static::createClient();
        $client->enableProfiler();
        $this->em =$client->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testFindVehiculeDispo()
    {
        $vehicule = $this->em
            ->getRepository('MainBundle:Vehicule')
            ->findVehiculeDispo('2017-01-01','2017-01-02','Nantes')
        ;
        //Retourne le vehicule 
        $this->assertEquals('EJ 510 FD', $vehicule->getImmatriculation());
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}
