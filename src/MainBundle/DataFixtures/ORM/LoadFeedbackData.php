<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use MainBundle\Entity\Feedback;

class LoadFeedbackData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $listFeedback = array(
              array('reservation2', 14520, 'Il y avait un pneu de creuvé', new \DateTime('2017/11/04 11:01:25'), new \DateTime('2017/11/04 11:01:25') )
        );
        
        echo "Création des Feedbacks \n";
        
        foreach ($listFeedback as $key => $values) {
            //création d'un nouveau Feedback
            $feedback = new Feedback();
            
            //on attribue les valeurs à l'utilisateur que l'on vient de créer
            $feedback->setReservation($values[0] != NULL ? $this->getReference($values[0]) : NULL)
                ->setKilometres($values[1])
                ->setCommentaires($values[2])
                ->setDateCreation($values[3])
                ->setDateDerMaj($values[4]);
            //on persiste le Feedback
            $manager->persist($feedback);
            //on crée la référence pour les autres dataLoaders
            $this->addReference('feedback'.$key, $feedback);
            echo "Référence feedback".$key." créé \n";
        }
      
        $manager->flush();
        echo sizeof($listFeedback). " Feedback ont été créés avec succès \n";
    }
    
    public function getOrder() {
        return 5;
    }
}

