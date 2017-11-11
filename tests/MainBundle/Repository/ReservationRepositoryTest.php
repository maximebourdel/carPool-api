<?php

// tests/MainBundle/Repository/ReservationRepositoryTest.php
namespace Tests\MainBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test du respository Reservation
 *
 * @author Maxime Bourdel
 */
class ReservationRepositoryTest extends WebTestCase
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

    public function testFindMyReservations()
    {
        $listVehicule = $this->em
            ->getRepository('MainBundle:Reservation')
            ->findMyReservations('maxime.bourdel@businessdecision.com')
        ;
        //Doit retourner les 4 véhicules dans une liste
        $this->assertEquals(4, sizeof($listVehicule));
    }

    public function testFindCreneauxByAnneeMois()
    {
        $listCreneaux = $this->em
            ->getRepository('MainBundle:Reservation')
            ->findCreneauxByAnneeMois(2017,11)
        ;
        //Vérification du résultat
        $this->assertEquals(300         , sizeof($listCreneaux));
        $this->assertEquals(29          , $listCreneaux[58]['jour']);
        $this->assertEquals(1           , $listCreneaux[58]['is_reserve']);
        $this->assertEquals('BOURDEL'   , $listCreneaux[58]['nom']);
        $this->assertEquals('Maxime'    , $listCreneaux[58]['prenom']);
        $this->assertEquals('DM 235 EY' , $listCreneaux[58]['immatriculation']);
    }
    
    public function testFindFeedbackableReservations() {
        $listReservation = $this->em
            ->getRepository('MainBundle:Reservation')
            ->findFeedbackableReservations()
        ;
        //Vérification du résultat
        $this->assertEquals(1, sizeof($listReservation));      
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
