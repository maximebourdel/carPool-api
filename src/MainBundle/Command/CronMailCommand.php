<?php

// src/AppBundle/Command/CronMailCommand.php
namespace MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use MainBundle\Service\Mailer\MailManager;

class CronMailCommand extends ContainerAwareCommand

{
    /**
     * Ajoute la fonction bin/console cron:mail
     */
    protected function configure()
    {
        $this
        // bin/console
        ->setName('cron:mail')
        ->setDescription('Stocke dans le spool les mails pour les utilisateurs n\'ayant pas fait le feedback de leurs réservations')
        ->setHelp('Stocke dans le spool les mails pour les utilisateurs n\'ayant pas fait le feedback de leurs réservations')
        ;
    }

    /**
     * Envoie les mails aux utilisateurs n'ayant pas fait leurs feedback
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reservations = $this->getContainer()->get('doctrine')
                ->getRepository('MainBundle:Reservation')
                ->findNotRatedFinishedReservations();
        //Commentaire
        $output->writeln([
            '============',
            'Envoi des emails en cours',
        ]);
        foreach ($reservations as $reservation){
            //Stockage du mail dans le spool
            $mailManager = new MailManager($this->getContainer());
            $mailManager->sendMailDateFinDepasseeReservation($reservation); 
        }
        $output->writeln([
            'Envoi des emails terminé',
            sizeof($reservations) . ' mails envoyés',
            '============',
        ]);
    }
}