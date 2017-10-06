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
     * Envoie le mail de demande d'annulation de l'utilisateur
     * @param Reservation $reservation
     */
    function sendMailToAdminAnnulationReservation (Reservation $reservation){
        
        $message = (new \Swift_Message('Annulation de la réservation de '
                . $reservation->getNom().' '. $reservation->getPrenom() ))
            ->setFrom('carpool@businessdecision.com')
            //On envoie aux admins
            ->setTo($this->getListeAdmin())
            ->setBody(
               $this->templating->render(
                    // app/Resources/views/Emails/annulation_reservation.html
                    'Emails/annulation_reservation.html.twig',
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
    function sendMailToAdminDemandeReservation (Reservation $reservation){
        
        $message = (new \Swift_Message('Demande de reservation de '
                . $reservation->getNom().' '. $reservation->getPrenom() ))
            ->setFrom('carpool@businessdecision.com')
            //On envoie aux admins
            ->setTo($this->getListeAdmin())
            ->setBody(
                $this->templating->render(
                    // app/Resources/views/Emails/demande_reservation.html.twig
                    'Emails/demande_reservation.html.twig',
                    array('reservation' => $reservation)
                ),
                'text/html'
            );
        
        $this->mailer->send($message);
    }
    
    /**
     * Envoie le mail de changement de statut à l'utilisateur concernant la réservation effectué par l'admin
     * @param Reservation $reservation
     */
    function sendMailChangementStatutReservation (Reservation $reservation){
        
        $message = (new \Swift_Message('Votre réservation pour le '. $reservation->getDateDebut()->format('d/m/Y').' est modifiée'))
            ->setFrom('carpool@businessdecision.com')
            //On envoie à celui qui a fait la demande
            ->setTo($reservation->getEmail())
            ->setBody(
               $this->templating->render(
                    // app/Resources/views/Emails/changement_statut.html.twig
                    'Emails/changement_statut.html.twig',
                    array('reservation' => $reservation)
                ),
                'text/html'
            );
        
        $this->mailer->send($message);
    }

    /**
     * Envoie un mail aux utilisateurs remplissant les conditions suivantes :
     * avoir une réservation confirmée donc la date de fin est inférieure ou égale à sysdate-1 
     * @return Array Liste des admin ex : ['adr1','adr2']
     */
    function sendMailDateFinDepasseeReservation (Reservation $reservation){
        
        $message = (new \Swift_Message('Comment s\'est passée votre réservation terminée le  '. $reservation->getDateFin()->format('d/m/Y').' ?'))
            ->setFrom('carpool@businessdecision.com')
            //On envoie à celui qui a fait la demande
            ->setTo($reservation->getEmail())
            ->setBody(
               $this->templating->render(
                    // app/Resources/views/Emails/reservation_depassee.html.twig
                    'Emails/reservation_depassee.html.twig',
                    array('reservation' => $reservation)
                ),
                'text/html'
            );
        
        $this->mailer->send($message);
    }    
    
    /**
     * Retourne la liste des aministrateurs de la table Admin 
     * @return Array Liste des admin ex : ['adr1','adr2']
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