<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Request;

use MainBundle\Service\Mailer\MailManager;

//Ne pas supprimer sont utilisés dans les annotations
use FOS\RestBundle\Controller\Annotations as Rest;
use  Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Controller pour les réservations en mode Admin
 * @package MainBundle\Controller
 * @author Maxime Bourdel
 */
class ReservationAdminController extends FOSRestController {
    
    /**
     * @ApiDoc(
     *  description="Retourne la liste complète des Reservation"
     *  , output="MainBundle\Entity\Reservation"
     * )
     * @Rest\View()
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException 
     */
    public function getReservationAllAction()
    {
        //retourne la liste complète
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->findBy([], ['dateCreation' => 'DESC']);
    }
    
    /**
     * @ApiDoc(
     *  description="Change le statut d'une réservation"
     *  , requirements={
     *      {
     *          "name"="request",
     *          "dataType"="Symfony\Component\HttpFoundation\Request",
     *          "description"="Paramètres représentant l'id réservation et le nouveau statut ex : { id: 88, statut: 'Confirmée' }"
     *      }
     *  }
     *  , output="MainBundle\Entity\Reservation"
     * )
     * @Rest\View()
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function putReservationStatutAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $jsonResponse = json_decode($request->getContent(), true);

        $reservation = $this->getDoctrine()->getRepository('MainBundle:Reservation')->find($jsonResponse['id']);
        //Mise à jour de la date
        $reservation->setDateDerMaj(new \DateTime());
        //Mise à jour du statut
        $updateReservation = $reservation->setStatut($jsonResponse['statut']);
        
        $em->flush();
        
        //Envoi du mail en spool
        $mailManager = new MailManager($this->container);
        $mailManager->sendMailChangementStatutReservation($reservation); 
        
        return $updateReservation ;
    }

    
    
}
