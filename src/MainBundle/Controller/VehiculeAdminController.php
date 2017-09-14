<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Controller pour les véhicules
 * @package MainBundle\Controller
 * @author Maxime Bourdel
 */
class VehiculeAdminController extends FOSRestController
{
    
    /**
     * Retourne un Vehicule individuel pour un identifiant donné
     *
     * @Rest\View()
     * @param String $id identifiant du véhicule
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getVehiculeAction($id)
    {
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Vehicule')
                    ->find($id);
    }    
    
    /**
     * Retourne la lite complète des Vehicules
     *
     * @Rest\View()
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getVehiculeAllAction()
    {
        //retourne tous les resultats
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Vehicule')
                    ->findAll();
    }
    
    

    
}
