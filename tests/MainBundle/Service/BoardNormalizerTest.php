<?php

// tests/MainBundle/Service/MailControllerTest.php
namespace Tests\MainBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use MainBundle\Service\BoardNormalizer;
use Symfony\Component\Serializer\Serializer;

use MainBundle\Entity\Reservation;
use MainBundle\Entity\Vehicule;

class BoardNormalizerTest extends WebTestCase
{
    public function testDenormalize()
    {
        $normalizer = new BoardNormalizer();
        $encoder = new JsonEncoder();
        $serializer = new Serializer([$normalizer], [$encoder]);

        //initialisation des donnees avec un underscore
        $data = array (
             'date_arrivee_vehicule_bd' => '20170101'
            , 'date_premiere_immatriculation' => '20170102'
            , 'date_debut' => '20170103' 
            , 'date_fin' => '20170104'
            , 'is_feedbackable' => 1
        );
        
        //Test des Vehicules
        $serialVehicule = $serializer->deserialize(
            json_encode($data)
            , Vehicule::class
            , 'json'
        );
        $this->assertEquals(new \DateTime(20170101), $serialVehicule->getDateArriveeVehiculeBd());
        $this->assertEquals(new \DateTime(20170102), $serialVehicule->getDatePremiereImmatriculation());
        
        //Test des Reservations
        $serialReservation = $serializer->deserialize(
            json_encode($data)
            , Reservation::class
            , 'json'
        );
        $this->assertEquals(new \DateTime(20170103), $serialReservation->getDateDebut());
        $this->assertEquals(new \DateTime(20170104), $serialReservation->getDateFin());
        $this->assertEquals(1, $serialReservation->getIsFeedbackable());
    }
}
