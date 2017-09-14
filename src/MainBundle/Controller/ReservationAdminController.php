<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

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
}
