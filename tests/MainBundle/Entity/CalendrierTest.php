<?php

namespace Test\MainBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use MainBundle\Entity\Calendrier;

class CalendrierTest extends WebTestCase
{
    public function testGetId() {
        $calendrier = new Calendrier();
        $this->assertEquals(null, $calendrier->getId());
    }
    
    public function testGetAnnee() {
        $calendrier = new Calendrier();
        $calendrier->setAnnee(2017);
        $this->assertAttributeEquals(2017, 'annee', $calendrier);
    }
    
    public function testSetAnnee() {
        $calendrier = new Calendrier();
        $calendrier->setAnnee(2017);
        $this->assertEquals(2017, $calendrier->getAnnee());
    }
    
    public function testGetMois() {
        $calendrier = new Calendrier();
        $calendrier->setMois(2);
        $this->assertAttributeEquals(2, 'mois', $calendrier);
    }
    
    public function testSetMois() {
        $calendrier = new Calendrier();
        $calendrier->setMois(2);
        $this->assertEquals(2, $calendrier->getMois());
    }
    
    public function testGetJour() {
        $calendrier = new Calendrier();
        $calendrier->setJour(28);
        $this->assertAttributeEquals(28, 'jour', $calendrier);
    }
    
    public function testSetJour() {
        $calendrier = new Calendrier();
        $calendrier->setJour(28);
        $this->assertEquals(28, $calendrier->getJour());
    }
    
        public function testSetSemaine() {
        $calendrier = new Calendrier();
        $calendrier->setSemaine(42);
        $this->assertAttributeEquals(42, 'semaine', $calendrier);
    }
    
    public function testGetSemaine() {
        $calendrier = new Calendrier();
        $calendrier->setSemaine(42);
        $this->assertEquals(42, $calendrier->getSemaine());
    }    
    
    public function testSetDate() {
        $calendrier = new Calendrier();
        $date = new \DateTime();
        $calendrier->setDate($date);
        $this->assertAttributeEquals($date, 'date', $calendrier);
    }
    
    public function testGetDate() {
        $calendrier = new Calendrier();
        $date = new \DateTime();
        $calendrier->setDate($date);
        $this->assertEquals($date, $calendrier->getDate());
    }    
}
