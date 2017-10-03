<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

//Ne pas supprimer sont utilisés dans les annotations
use FOS\RestBundle\Controller\Annotations as Rest;
use  Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Controller pour les véhicules en mode Admin
 * @package MainBundle\Controller
 * @author Maxime Bourdel
 */
class VehiculeAdminController extends FOSRestController
{
    
    /**
     * @ApiDoc(
     *  description="Retourne un Vehicule individuel pour un identifiant donné"
     *  , requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "description"="Paramètres représentant l'id du vehicule ex : 1"
     *      }
     *  }
     *  , output="MainBundle\Entity\Vehicule"
     * )
     * @Rest\View()
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
     * 
     * @ApiDoc(
     *  description="Retourne la lite complète des Vehicules"
     *  , output={ "class"=MainBundle\Entity\Vehicule::class, "collection"=true }
     * )
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
