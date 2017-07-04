<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class VehiculeController
 * @package MainBundle\Controller
 * 
 */
class VehiculeController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Retourne une liste d'Vehicule
     *
     * @Rest\View()
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getAllAction()
    {
        //retourne tous les resultats
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Vehicule')
                    ->findAll();
    }
    
    
    /**
     * Retourne un Vehicule individuel
     *
     * @Rest\View()
     * @param String $entry
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getAction($entry)
    {
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Vehicule')
                    ->searchBy($entry);
    }
    
    
}
