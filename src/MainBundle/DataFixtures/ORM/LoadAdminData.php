<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use MainBundle\Entity\Admin;

class LoadAdminData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $listAdmin = array(
             array('maxime.bourdel@businessdecision.com' )
        );
        
        echo "Création des Admins \n";
        
        foreach ($listAdmin as $key => $values) {
            //création d'un nouveau Vehicule
            $admin = new Admin();
            
            //on attribue les valeurs à l'utilisateur que l'on vient de créer
            $admin->setEmail($values[0]);
            //on persiste le Vehicule
            $manager->persist($admin);
        }
      
        $manager->flush();
        echo sizeof($listAdmin). " Admin ont été créés avec succès \n";
    }
    
    public function getOrder() {
        return 1;
    }
}

