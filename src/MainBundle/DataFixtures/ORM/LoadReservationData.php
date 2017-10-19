<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use MainBundle\Entity\Reservation;

class LoadReservationData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $listReservation = array(
              array('vehicule1', NULL, 'maxime.bourdel@businessdecision.com', 'BOURDEL', 'Maxime' , new \DateTime('2017/11/18'), new \DateTime('2017/11/18'), 'En cours d\'administration',0 , new \DateTime('2017/10/31 14:01:05'), new \DateTime('2017/10/18 14:01:05') )
            , array('vehicule1', NULL, 'maxime.bourdel@businessdecision.com', 'BOURDEL', 'Maxime' , new \DateTime('2017/11/25'), new \DateTime('2017/11/29'), 'Confirmée',1 , new \DateTime('2017/11/14 14:20:55'), new \DateTime('2017/10/19 11:12:55') )                        
            , array('vehicule1', NULL, 'maxime.bourdel@businessdecision.com', 'BOURDEL', 'Maxime' , new \DateTime('2017/10/22'), new \DateTime('2017/10/27'), 'Terminée',1 , new \DateTime('2017/10/18 18:20:55'), new \DateTime('2017/10/21 09:55:55') )            

        );
        
        echo "Création des Reservations \n";
        
        foreach ($listReservation as $key => $values) {
            //création d'un nouveau Reservation
            $reservation = new Reservation();
            
            //on attribue les valeurs à l'utilisateur que l'on vient de créer
            $reservation->setVehicule($values[0] != NULL ? $this->getReference($values[0]) : NULL)
                ->setFeedback($values[1] != NULL ? $this->getReference($values[1]) : NULL)
                ->setEmail($values[2])
                ->setNom($values[3])
                ->setPrenom($values[4])
                ->setDateDebut($values[5])
                ->setDateFin($values[6])
                ->setStatut($values[7])
                ->setIsFeedbackable($values[8])
                ->setDateCreation($values[9])
                ->setDateDerMaj($values[10]);
            //on persiste le Reservation
            $manager->persist($reservation);
            //on crée la référence pour les autres dataLoaders
            $this->addReference('reservation'.$key, $reservation);
            echo "Référence reservation".$key." créé \n";
        }
      
        $manager->flush();
        echo sizeof($listReservation). " Reservation ont été créés avec succès \n";
    }
    
    public function getOrder() {
        return 4;
    }
}

