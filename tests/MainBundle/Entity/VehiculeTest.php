<?php

namespace Test\MainBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Doctrine\Common\Collections\ArrayCollection;

use MainBundle\Entity\Vehicule;
use MainBundle\Entity\Reservation;

class VehiculeTest extends WebTestCase
{
    public function testGetId() {
        $vehicule = new Vehicule();
        $this->assertEquals(null, $vehicule->getId());
    }
    
    public function testSetImmatriculation() {
        $vehicule = new Vehicule();
        $vehicule->setImmatriculation('EJ 510 FD');
        $this->assertAttributeEquals('EJ 510 FD', 'immatriculation', $vehicule);
    }
    
    public function testGetImmatriculation() {
        $vehicule = new Vehicule();
        $vehicule->setImmatriculation('EJ 510 FD');
        $this->assertEquals('EJ 510 FD', $vehicule->getImmatriculation());
    }
    
    public function testAddReservation() {
        $vehicule = new Vehicule();
        $reservations = new ArrayCollection();
        $reservations[] = new Reservation();
        $vehicule->addReservation($reservations[0]);
        $this->assertAttributeEquals($reservations, 'reservations', $vehicule);
    }
    
    public function testRemoveReservation() {
        $vehicule = new Vehicule();
        $reservations = new ArrayCollection();
        $reservations[] = new Reservation();
        $vehicule->addReservation($reservations[0]);
        $vehicule->removeReservation($reservations[0]);
        $this->assertAttributeEquals(new ArrayCollection(), 'reservations', $vehicule);
    }
    
    public function testGetReservations() {
        $vehicule = new Vehicule();
        $reservations = new ArrayCollection();
        $reservations[] = new Reservation();
        $vehicule->addReservation($reservations->get(0));
        $this->assertEquals($reservations, $vehicule->getReservations());
    }
    
    public function testSetNomResponsable() {
        $vehicule = new Vehicule();
        $vehicule->setNomResponsable('Maxime BOURDEL');
        $this->assertAttributeEquals('Maxime BOURDEL', 'nomResponsable', $vehicule);
    }
    
    public function testGetNomResponsable() {
        $vehicule = new Vehicule();
        $vehicule->setNomResponsable('Maxime BOURDEL');
        $this->assertEquals('Maxime BOURDEL', $vehicule->getNomResponsable());
    }
    
    public function testSetVille() {
        $vehicule = new Vehicule();
        $vehicule->setVille('Nantes');
        $this->assertAttributeEquals('Nantes', 'ville', $vehicule);
    }
    
    public function testGetVille() {
        $vehicule = new Vehicule();
        $vehicule->setVille('Nantes');
        $this->assertEquals('Nantes', $vehicule->getVille());
    }  
    
    public function testSetMarque() {
        $vehicule = new Vehicule();
        $vehicule->setMarque('Fiat');
        $this->assertAttributeEquals('Fiat', 'marque', $vehicule);
    }
    
    public function testGetMarque() {
        $vehicule = new Vehicule();
        $vehicule->setMarque('Fiat');
        $this->assertEquals('Fiat', $vehicule->getMarque());
    }

    public function testSetKilometrage() {
        $vehicule = new Vehicule();
        $vehicule->setKilometrage('123456');
        $this->assertAttributeEquals('123456', 'kilometrage', $vehicule);
    }
    
    public function testGetKilometrage() {
        $vehicule = new Vehicule();
        $vehicule->setKilometrage('123456');
        $this->assertEquals('123456', $vehicule->getKilometrage());
    }

    public function testSetTypeAcquisition() {
        $vehicule = new Vehicule();
        $vehicule->setTypeAcquisition('Location');
        $this->assertAttributeEquals('Location', 'typeAcquisition', $vehicule);
    }
    
    public function testGetTypeAcquisition() {
        $vehicule = new Vehicule();
        $vehicule->setTypeAcquisition('Location');
        $this->assertEquals('Location', $vehicule->getTypeAcquisition());
    }
    
    public function testSetDateArriveeVehiculeBd() {
        $vehicule = new Vehicule();
        $date = new \DateTime();
        $vehicule->setDateArriveeVehiculeBd($date);
        $this->assertAttributeEquals($date, 'dateArriveeVehiculeBd', $vehicule);
    }
    
    public function testGetDateArriveeVehiculeBd() {
        $vehicule = new Vehicule();
        $date = new \DateTime();
        $vehicule->setDateArriveeVehiculeBd($date);
        $this->assertEquals($date, $vehicule->getDateArriveeVehiculeBd());
    }    

    public function testSetDatePremiereImmatriculation() {
        $vehicule = new Vehicule();
        $date = new \DateTime();
        $vehicule->setDatePremiereImmatriculation($date);
        $this->assertAttributeEquals($date, 'datePremiereImmatriculation', $vehicule);
    }
    
    public function testGetDatePremiereImmatriculation() {
        $vehicule = new Vehicule();
        $date = new \DateTime();
        $vehicule->setDatePremiereImmatriculation($date);
        $this->assertEquals($date, $vehicule->getDatePremiereImmatriculation());
    }

    public function testSetDerniereRevision() {
        $vehicule = new Vehicule();
        $vehicule->setDerniereRevision('Le 20/10/2017');
        $this->assertAttributeEquals('Le 20/10/2017', 'derniereRevision', $vehicule);
    }
    
    public function testGetDerniereRevision() {
        $vehicule = new Vehicule();
        $vehicule->setDerniereRevision('Le 20/10/2017');
        $this->assertEquals('Le 20/10/2017', $vehicule->getDerniereRevision());
    }
}
