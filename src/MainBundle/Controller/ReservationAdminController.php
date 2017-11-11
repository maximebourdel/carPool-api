<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Request;

use MainBundle\Service\Mailer\MailManager;

//Ne pas supprimer sont utilisés dans les annotations
use FOS\RestBundle\Controller\Annotations as Rest;
use  Nelmio\ApiDocBundle\Annotation\ApiDoc;
//Pour définir les routes
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;

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
     * @Get("/reservation/all")
     */
    public function getAllReservationAllAction()
    {
        //retourne la liste complète des réservation
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
     * @Put("/reservation/changeStatus")
     */
    public function changeStatutReservationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $jsonResponse = json_decode($request->getContent(), true);

        $reservation = $this->getDoctrine()->getRepository('MainBundle:Reservation')->find($jsonResponse['id']);
        //Mise à jour de la date
        $reservation->setDateDerMaj(new \DateTime());
        //Mise à jour du statut
        $updateReservation = $reservation->setStatut($jsonResponse['statut']);
        
        $em->flush();
        
        //Stockage du mail dans le spool
        $mailManager = new MailManager($this->container);
        $mailManager->sendMailChangementStatutReservation($reservation); 
        
        return $updateReservation ;
    }
}
