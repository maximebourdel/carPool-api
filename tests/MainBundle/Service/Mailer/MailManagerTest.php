<?php

// tests/MainBundle/Service/Mailer/MailControllerTest.php
namespace Tests\MainBundle\Service\Mailer;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use MainBundle\Service\Mailer\MailManager;

class MailControllerTest extends WebTestCase
{
    /**
     * Teste le code de retour des envois de mails
     */
    public function testSendMail() {
        
        $client = static::createClient();
        $client->enableProfiler();
        
        $reservation = $this->recupereReservation($client);
        
        $mailManager = new MailManager($client->getContainer());
        
        //Ajouter l'assert avec les envois de mails
        $this->assertTrue($mailManager->sendMailToAdminDemandeReservation($reservation));
        $this->assertTrue($mailManager->sendMailChangementStatutReservation($reservation));
        $this->assertTrue($mailManager->sendMailToAdminAnnulationReservation($reservation));
        $this->assertTrue($mailManager->sendMailDemandeFeedback($reservation));
    }
    
    /**
     * Récupère la premiere reservation en BDD
     * @param Client $client client pour le test
     * @return Reservation reservation sont l'id est le plus bas
     */
    private function recupereReservation(Client $client){
        return $client->getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository('MainBundle:Reservation')
            ->findOneBy(array(),array('id' => 'ASC'));
    }
}
