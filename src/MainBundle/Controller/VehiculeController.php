<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

use Symfony\Component\HttpFoundation\Request;

//Ne pas supprimer sont utilisés dans les annotations
use FOS\RestBundle\Controller\Annotations as Rest;
use  Nelmio\ApiDocBundle\Annotation\ApiDoc;


/**
 * Controller pour les véhicules
 * @package MainBundle\Controller
 * @author Maxime Bourdel
 */
class VehiculeController extends FOSRestController implements ClassResourceInterface
{
    
    /**
     * @ApiDoc(
     *  description="Retourne le meilleur véhicules pour une date donnée (en fonction des Km)"
     *  , requirements={
     *      {
     *          "name"="request",
     *          "dataType"="Symfony\Component\HttpFoundation\Request",
     *          "description"="Paramètres représentant date début/fin ainsi que la ville ex : {dateDebut: '2017-10-10', dateFin: '2017-10-13', ville: 'Nantes'}"
     *      }
     *  }
     *  , output="MainBundle\Entity\Vehicule"
     * )
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
