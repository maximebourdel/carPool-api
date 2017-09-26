<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Request;


use MainBundle\Service\Mailer\MailManager;


use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Controller pour les réservations en mode Admin
 * @package MainBundle\Controller
 * @author Maxime Bourdel
 */
class ReservationAdminController extends FOSRestController {
    
    /**
     * Retourne la liste complète des Reservation
     *
     * @Rest\View()
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function getReservationAllAction()
    {
        //retourne la liste complète
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->findBy([], ['dateCreation' => 'DESC']);
    }
    
    /**
     * Change le statut d'une réservation
     *
     * @Rest\View()
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function putReservationStatutAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $jsonResponse = json_decode($request->getContent(), true);

        $reservation = $this->getDoctrine()->getRepository('MainBundle:Reservation')->find($jsonResponse['id']);
        //Mise à jour de la date
        $reservation->setDateDerMaj(new \DateTime());
        
        $updateReservation = $reservation->setStatut($jsonResponse['statut']);
        
        $em->flush();
        
        //Envoi du mail en spool
        $mailManager = new MailManager($this->container);
        $mailManager->sendMailChangementStatutReservation($reservation); 
        
        return $updateReservation ;
    }

    
    
}
