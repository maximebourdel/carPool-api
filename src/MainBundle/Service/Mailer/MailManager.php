<?php

namespace MainBundle\Service\Mailer;


use MainBundle\Entity\Reservation;
use Symfony\Component\DependencyInjection\ContainerInterface;
 

class MailManager
{
    private $mailer;
    private $templating;
    private $doctrine;
 
    public function __construct(ContainerInterface $container)
    {
        $this->mailer = $container->get('mailer');
        $this->templating = $container->get('templating');
        $this->doctrine = $container->get('doctrine');
    }
 
    /**
     * Envoie le mail de changement de statut concernant la réservation
     * @param Reservation $reservation
     */
    function sendMailChangementStatutReservation (Reservation $reservation){
        
        $message = (new \Swift_Message('Changement sur la réservation de  '. $reservation->getEmail()))
            ->setFrom('maxime.bourdel@businessdecision.com')
            //On envoie aux admin et à celui qui a fait la demande
            ->setTo(array_merge(
                    $this->getListeAdmin()
                    ,[$reservation->getEmail() => $reservation->getEmail()]
            ))
            ->setBody(
               $this->templating->render(
                    // app/Resources/views/Emails/registration.html.twig
                    'Emails/changement_statut.html.twig',
                    array('reservation' => $reservation)
                ),
                'text/html'
            );
        
        $this->mailer->send($message);
    }
    
    /**
     * Envoie le mail d'envoi de réservation
     * @param Reservation $reservation
     */
    function sendMailDemandeReservation (Reservation $reservation){
        
        $message = (new \Swift_Message('Demande de reservation de '. $reservation->getEmail()))
            /*carpool@businessdecision.com*/
            ->setFrom('maxime.bourdel@businessdecision.com')
            ->setTo($this->getListeAdmin())
            ->setBody(
                $this->templating->render(
                    // app/Resources/views/Emails/registration.html.twig
                    'Emails/demande_reservation.html.twig',
                    array('reservation' => $reservation)
                ),
                'text/html'
            );
        
        $this->mailer->send($message);
    }
    
    /**
     * Retourne la liste des aministrateurs de la table Admin 
     * @return array Liste des admin ex : ['adr1','adr2']
     */
    function getListeAdmin (){
        //On récupère les admins
        $listAdmin = $this->doctrine->getRepository('MainBundle:Admin')->findAll();
        //On stocke leurs mails dans un tableau
        foreach ($listAdmin as $admin){
            $listMailsAdmins[$admin->getEmail()] = $admin->getEmail();
        }
                
        return $listMailsAdmins;
    }
}