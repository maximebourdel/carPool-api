<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use MainBundle\Entity\Vehicule;

class LoadVehiculeData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $listVehicules = array(
             array('EJ 510 FD', 'Nantes', NULL, NULL, 'Location', 'Martine Donnadieu', 'Polo', 4049, 'Sera à faire au 20 000 km' )
            , array('DM 235 EY', 'Nantes', new \DateTime('2014-12-02'), new \DateTime('2014-12-01'), 'Location', 'Jeanne Gosset', 'Fiesta', 14442, '11/2015 : 21 208  km' )
            , array('EE 740 KP', 'Nantes', new \DateTime('2016-08-03'), new \DateTime('2016-09-01'), 'Location', 'Gaëlle Michon', 'Polo', 14442, 'Sera à faire au 20 000 km' )
            , array('DS 371 XX', 'Nantes', new \DateTime('2016-06-30'), new \DateTime('2015-08-01'), 'Location', 'Jeanne Gosset', 'Fiesta', 24670, '08/2016 : 20  000 km' )            
            , array('DS 608 XX', 'Nantes', new \DateTime('2015-06-30'), new \DateTime('2015-07-01'), 'Location', 'Jeanne Gosset', 'Fiesta', 32767, '2017-04-01' )            
            , array('DS 874 XT', 'Nantes', new \DateTime('2015-06-30'), new \DateTime('2015-07-01'), 'Location', 'Jeanne Gosset', 'Fiesta', 35731, 'fin juin 2017' )            
            , array('DS 507 XV', 'Nantes', new \DateTime('2015-06-30'), new \DateTime('2015-07-01'), 'Location', 'Jeanne Gosset', 'Fiesta', 44737, '05/2016 : 20 000 km' )            
            , array('EK 666 EY', 'Nantes', new \DateTime('2014-04-02'), new \DateTime('2017-04-01'), 'Location', 'Jeanne Gosset', 'Fiesta', 51669, 'Sera à faire au 20 000 km' )            
            , array('DL 396 KP', 'Niort', new \DateTime('2014-10-31'), new \DateTime('2014-11-01'), 'Location', 'Martine Donnadieu', 'Fiesta', 53511, '09/2015 : 20 000 km                                        06/2016 : 41 516 km' )            
            , array('DM 345 EY', 'Niort', new \DateTime('2014-02-12'), new \DateTime('2017-12-01'), 'Location', 'Martine Donnadieu', 'Fiesta', 79040, '11/2015 : 20 000 km                                            04/2016 : 40 000km' )
        );
        
        echo "Création des Vehicules \n";
        
        foreach ($listVehicules as $key => $values) {
            //création d'un nouveau Vehicule
            $vehicule = new Vehicule();
            
            //on attribue les valeurs à l'utilisateur que l'on vient de créer
            $vehicule->setImmatriculation($values[0])
                ->setVille($values[1])
                ->setDatePremiereImmatriculation($values[2])
                ->setDateArriveeVehiculeBd($values[3])
                ->setTypeAcquisition($values[4])
                ->setNomResponsable($values[5])
                ->setMarque($values[6])
                ->setKilometrage($values[7])
                ->setDerniereRevision($values[8]);
            //on persiste le Vehicule
            $manager->persist($vehicule);
            //on crée la référence pour les autres dataLoaders
            $this->addReference('vehicule'.$key, $vehicule);
            echo "Référence vehicule".$key." créé \n";
        }
      
        $manager->flush();
        echo sizeof($listVehicules). " Vehicules ont été créés avec succès \n";
    }
    
    public function getOrder() {
        return 2;
    }
}

