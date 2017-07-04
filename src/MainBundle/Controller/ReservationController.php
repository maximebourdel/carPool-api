<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use MainBundle\Entity\Reservation;

use MainBundle\Service\BoardNormalizer;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * Class ReservationController
 * @package MainBundle\Controller
 * 
 */
class ReservationController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Retourne une liste d'Reservation
     *
     * @Rest\View()
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function getAllAction()
    {
        //retourne la liste complète
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->findAll();
    }
    
    /**
     * Retourne une liste de Reservation
     *
     * @Rest\View()
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function getSumdaybydayAction()
    {
        //retourne la liste complète
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->findSumReservationsDayByDay();
    }

    /**
     * Retourne une liste de Reservation
     *
     * @Rest\View()
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function getRequeteAction()
    {
        //retourne la liste complète
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->findRequete();
    }
    
    /**
     * Retourne une Reservation individuelle
     *
     * @Rest\View()
     * @param String $entry
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function getAction($entry)
    {
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->searchBy($entry);
    }
    
    /**
     * Crée une reservation en fonction du JSON reçu
     *
     * @Rest\View()
     * @param Request $request
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function postAction(Request $request)
    {
        //Initialisation du Serializer
        $encoder = new JsonEncoder();
        $normalizer = new BoardNormalizer();
        $serializer = new Serializer([$normalizer], [$encoder]);
              
        //Cree la reservation a partir de la response 
        $newReservation = $serializer->deserialize(
            $request->getContent()
            , Reservation::class
            , 'json'
        );
        
        //On reencode le JSON
        $jsonResponse = json_decode($request->getContent(), true);
        
        // On récupere le vehicule associe
        $vehiculeInDB = $this->getDoctrine()
                            ->getRepository('MainBundle:Vehicule')
                            ->find( $jsonResponse['vehicule']['id']);
        
        //On l'affecte a l'objet Reservation que l'on vient de creer
        $newReservation->setVehicule($vehiculeInDB);
        
        //On insere puis on commit
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($newReservation);
        $em->flush();
        
        //On renvoie la nouvelle reservation
        return json_encode($newReservation);
    } 
    
    
    
}
