<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Controller pour les véhicules
 * @package MainBundle\Controller
 * @author Maxime Bourdel
 */
class VehiculeController extends FOSRestController implements ClassResourceInterface
{
    
    /**
     * Retourne le meilleur véhicules pour une date donnée (en fonction des Km)
     *
     * @Rest\View()
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function postDispoAction(Request $request)
    {
        $jsonResponse = json_decode($request->getContent(), true);
               
        return $this->getDoctrine()
                ->getRepository('MainBundle:Vehicule')
                ->findVehiculeDispo(
                        $jsonResponse['dateDebut']
                        , $jsonResponse['dateFin']
                        , $jsonResponse['ville']
        );
    }
    
    
}
