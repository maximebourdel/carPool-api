<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use MainBundle\Entity\Calendrier;

class LoadCalendrierData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $valDebCalendrier = new \DateTime('2017-01-01');
        $valFinCalendrier = new \DateTime('2018-01-01');
        //Compte le nombre de dates insérées
        $nbReservation = 0;
        echo "Création des Calendrier \n";
        
        
        while ($valDebCalendrier < $valFinCalendrier) {
            
            //création d'un nouveau Vehicule
            $calendrier = new Calendrier();

            //on attribue les valeurs à l'utilisateur que l'on vient de créer
            $calendrier->setDate($valDebCalendrier)
                ->setJour($valDebCalendrier->format("d"))
                ->setMois($valDebCalendrier->format("m"))
                ->setAnnee($valDebCalendrier->format("Y"))
                ->setSemaine($valDebCalendrier->format("N"));
            //on persiste le Vehicule
                
            if ($valDebCalendrier !== $valFinCalendrier) {
                $manager->persist($calendrier);
                $manager->flush();
            }
            $valDebCalendrier->modify('+1 day');
            $nbReservation++;
            
        }
        echo $nbReservation. " Calendrier ont été créés avec succès \n";
    }
    
    public function getOrder() {
        return 3;
    }
}

