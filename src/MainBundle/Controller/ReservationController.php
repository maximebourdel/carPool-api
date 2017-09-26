<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use MainBundle\Entity\Reservation;

use MainBundle\Service\Mailer\MailManager;

use MainBundle\Service\BoardNormalizer;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * Controller pour les réservations
 * @package MainBundle\Controller
 * @author Maxime Bourdel
 * 
 */
class ReservationController extends FOSRestController implements ClassResourceInterface
{

    /**
     * Retourne une liste d'Reservation pour un simple utilisateur
     *
     * @Rest\View()
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function postMyListAction(Request $request)
    {
        $email = $request->getContent();

        //retourne la liste complète
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->findMyReservations($email);
    }

    /**
     * Change le statut d'une réservation
     *
     * @Rest\View()
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function putCancelAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $jsonResponse = json_decode($request->getContent(), true);

        $reservation = $this->getDoctrine()->getRepository('MainBundle:Reservation')->find($jsonResponse['id']);
        
        //Mise à jour de la date
        $updateReservation = $reservation->setDateDerMaj(new \DateTime());

        $em->flush();
        
        //Envoi du mail en spool
        $mailManager = new MailManager($this->container);
        $mailManager->sendMailToAdminAnnulationReservation($reservation); 
        
        return $updateReservation ;
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
        //Retourne la liste complète
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->findSumReservationsDayByDay();
    }

    /**
     * Retourne des créneaux de réservation
     *
     * @Rest\View()
     * @param String $request
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function postCreneauxbyanneemoisAction(Request $request)
    {
        $jsonResponse = json_decode($request->getContent(), true);
        
        //Retourne la liste complète
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->findCreneauxByAnneeMois($jsonResponse['annee'],$jsonResponse['mois']);
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
        
        $newReservation->setDateCreation(new \DateTime());
        $newReservation->setDateDerMaj(new \DateTime());
        
        //On insere puis on commit
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($newReservation);
        $em->flush();
        
        //Envoi du mail en spool
        $mailManager = new MailManager($this->container);
        $mailManager->sendMailToAdminDemandeReservation($newReservation); 
        
        //On renvoie la nouvelle reservation
        return json_encode($newReservation);
    } 
    
    
    
}
