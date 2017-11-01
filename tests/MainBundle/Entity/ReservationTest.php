<?php

namespace Test\MainBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use MainBundle\Entity\Reservation;
use MainBundle\Entity\Vehicule;
use MainBundle\Entity\Feedback;

class ReservationTest extends WebTestCase
{
    public function testGetId() {
        $reservation = new Reservation();
        $this->assertEquals(null, $reservation->getId());
    }
    
    public function testSetFeedback() {
        $reservation = new Reservation();
        $feedback = new Feedback();
        $reservation->setFeedback($feedback);
        $this->assertAttributeEquals($feedback, 'feedback', $reservation);
    }
    
    public function testGetFeedback() {
        $reservation = new Reservation();
        $feedback = new Feedback();
        $reservation->setFeedback($feedback);
        $this->assertEquals($feedback, $reservation->getFeedback());
    }

    public function testSetVehicule() {
        $reservation = new Reservation();
        $vehicule = new Vehicule();
        $reservation->setVehicule($vehicule);
        $this->assertAttributeEquals($vehicule, 'vehicule', $reservation);
    }
    
    public function testGetVehicule() {
        $reservation = new Reservation();
        $vehicule = new Vehicule();
        $reservation->setVehicule($vehicule);
        $this->assertEquals($vehicule, $reservation->getVehicule());
    }
    
    public function testSetEmail() {
        $reservation = new Reservation();
        $reservation->setEmail('maxime.bourdel@businessdecision.com');
        $this->assertAttributeEquals(
            'maxime.bourdel@businessdecision.com'
            , 'email'
            , $reservation
        );
    }
    
    public function testGetEmail() {
        $reservation = new Reservation();
        $reservation->setEmail('maxime.bourdel@businessdecision.com');
        $this->assertEquals('maxime.bourdel@businessdecision.com'
            , $reservation->getEmail()
        );
    }
    
    public function testSetNom() {
        $reservation = new Reservation();
        $reservation->setNom('BOURDEL');
        $this->assertAttributeEquals('BOURDEL', 'nom', $reservation);
    }
    
    public function testGetNom() {
        $reservation = new Reservation();
        $reservation->setNom('BOURDEL');
        $this->assertEquals('BOURDEL', $reservation->getNom());
    } 

    public function testSetPrenom() {
        $reservation = new Reservation();
        $reservation->setPrenom('Maxime');
        $this->assertAttributeEquals('Maxime', 'prenom', $reservation);
    }
    
    public function testGetPrenom() {
        $reservation = new Reservation();
        $reservation->setPrenom('Maxime');
        $this->assertEquals('Maxime', $reservation->getPrenom());
    }

    public function testSetStatut() {
        $reservation = new Reservation();
        $reservation->setStatut('Confirmée');
        $this->assertAttributeEquals('Confirmée', 'statut', $reservation);
    }
    
    public function testGetStatut() {
        $reservation = new Reservation();
        $reservation->setStatut('Confirmée');
        $this->assertEquals('Confirmée', $reservation->getStatut());
    }

    public function testIsFeedbackable() {
        $reservation = new Reservation();
        $reservation->setIsFeedbackable(1);
        $this->assertAttributeEquals(1, 'isFeedbackable', $reservation);
    }
    
    public function testGetIsFeedbackable() {
        $reservation = new Reservation();
        $reservation->setIsFeedbackable(1);
        $this->assertEquals(1, $reservation->getIsFeedbackable());
    }
    
    public function testGetDateDebut() {
        $reservation = new Reservation();
        $date = new \DateTime();
        $reservation->setDateDebut($date);
        $this->assertEquals($date, $reservation->getDateDebut());
    }     
    
    public function testSetDateDebut() {
        $reservation = new Reservation();
        $date = new \DateTime();
        $reservation->setDateDebut($date);
        $this->assertAttributeEquals($date, 'dateDebut', $reservation);
    }
    
    public function testGetDateFin() {
        $reservation = new Reservation();
        $date = new \DateTime();
        $reservation->setDateFin($date);
        $this->assertEquals($date, $reservation->getDateFin());
    }     

    public function testSetDateFin() {
        $reservation = new Reservation();
        $date = new \DateTime();
        $reservation->setDateFin($date);
        $this->assertAttributeEquals($date, 'dateFin', $reservation);
    }
    
    public function testGetDateCreation() {
        $reservation = new Reservation();
        $date = new \DateTime();
        $reservation->setDateCreation($date);
        $this->assertEquals($date, $reservation->getDateCreation());
    }    
    
    public function testSetDateDerMaj() {
        $reservation = new Reservation();
        $date = new \DateTime();
        $reservation->setDateDerMaj($date);
        $this->assertAttributeEquals($date, 'dateDerMaj', $reservation);
    }
    
    public function testGetDateDerMaj() {
        $reservation = new Reservation();
        $date = new \DateTime();
        $reservation->setDateDerMaj($date);
        $this->assertEquals($date, $reservation->getDateDerMaj());
    }
}
