<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use MainBundle\Entity\Feedback;

use MainBundle\Service\BoardNormalizer;

//Ne pas supprimer sont utilisés dans les annotations
use FOS\RestBundle\Controller\Annotations as Rest;
use  Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Controller pour les Feedbacks
 * @package MainBundle\Controller
 * @author Maxime Bourdel
 */
class FeedbackController extends FOSRestController 
{
    
    /**
     * @ApiDoc(
     *  description="Crée une reservation en fonction du JSON reçu"
     *  , requirements={
     *      {
     *          "name"="request",
     *          "dataType"="Symfony\Component\HttpFoundation\Request",
     *          "description"="Request contenant un objet Feedback"
     *      }
     *  }
     *  , output="MainBundle\Entity\Feedback"
     * )
     * @Rest\View()
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function postFeedbackAction(Request $request)
    {
        //Initialisation du Serializer
        $encoder = new JsonEncoder();
        $normalizer = new BoardNormalizer();
        $serializer = new Serializer([$normalizer], [$encoder]);
        
        //Cree le feedback a partir de la response 
        $newFeedback = $serializer->deserialize(
            $request->getContent()
            , Feedback::class
            , 'json'
        );
        
        //On reencode le JSON
        $jsonResponse = json_decode($request->getContent(), true);
        
        // On récupere la réservation associee
        $reservarationInDB = $this->getDoctrine()
                            ->getRepository('MainBundle:Reservation')
                            ->find( $jsonResponse['reservation']['id']);
        
        //Modification des propriétés de la réservation
        $reservarationInDB->setStatut('Terminée');
        $reservarationInDB->setFeedback($newFeedback);
        $reservarationInDB->setDateDerMaj(new \DateTime());
                
        //Modification des propriétés du feedback
        //On l'affecte a l'objet Feedback que l'on vient de creer
        $newFeedback->setReservation($reservarationInDB);
        
        //On insere puis on commit
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($newFeedback);
        $em->flush();
        
        //On renvoie la nouvelle reservation
        return json_encode($newFeedback);
    } 
    
    
    
}
