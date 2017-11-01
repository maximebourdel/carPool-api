<?php

namespace Test\MainBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use MainBundle\Entity\Feedback;
use MainBundle\Entity\Reservation;

class FeedbackTest extends WebTestCase
{
    public function testGetId() {
        $feedback = new Feedback();
        $this->assertEquals(null, $feedback->getId());
    }
    
    public function testSetReservation() {
        $feedback = new Feedback();
        $reservation = new Reservation();
        $feedback->setReservation($reservation);
        $this->assertAttributeEquals($reservation, 'reservation', $feedback);
    }
    
    public function testGetReservation() {
        $feedback = new Feedback();
        $reservation = new Reservation();
        $feedback->setReservation($reservation);
        $this->assertEquals($reservation, $feedback->getReservation());
    }
    
    public function testSetCommentaires() {
        $feedback = new Feedback();
        $feedback->setCommentaires('OK');
        $this->assertAttributeEquals('OK', 'commentaires', $feedback);
    }
    
    public function testGetCommentaires() {
        $feedback = new Feedback();
        $feedback->setCommentaires('OK');
        $this->assertEquals('OK', $feedback->getCommentaires());
    }
    
    public function testSetKilometres() {
        $feedback = new Feedback();
        $feedback->setKilometres(123456);
        $this->assertAttributeEquals(123456, 'kilometres', $feedback);
    }
    
    public function testGetKilometres() {
        $feedback = new Feedback();
        $feedback->setKilometres(123456);
        $this->assertEquals(123456, $feedback->getKilometres());
    }   

    public function testSetDateCreation() {
        $feedback = new Feedback();
        $date = new \DateTime();
        $feedback->setDateCreation($date);
        $this->assertAttributeEquals($date, 'dateCreation', $feedback);
    }
    
    public function testGetDateCreation() {
        $feedback = new Feedback();
        $feedback->setDateCreation('123456');
        $this->assertEquals('123456', $feedback->getDateCreation());
    }    
    
    public function testSetDateDerMaj() {
        $feedback = new Feedback();
        $date = new \DateTime();
        $feedback->setDateDerMaj($date);
        $this->assertAttributeEquals($date, 'dateDerMaj', $feedback);
    }
    
    public function testGetDateDerMaj() {
        $feedback = new Feedback();
        $feedback->setDateDerMaj('123456');
        $this->assertEquals('123456', $feedback->getDateDerMaj());
    }
}
