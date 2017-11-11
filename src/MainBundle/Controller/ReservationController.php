<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use MainBundle\Entity\Reservation;

use MainBundle\Service\Mailer\MailManager;

use MainBundle\Service\BoardNormalizer;

//Ne pas supprimer sont utilisés dans les annotations
use FOS\RestBundle\Controller\Annotations as Rest;
use  Nelmio\ApiDocBundle\Annotation\ApiDoc;
//Pour définir les routes
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;

/**
 * Controller pour les réservations
 * @package MainBundle\Controller
 * @author Maxime Bourdel
 */
class ReservationController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Retourne une réservation pour un utilisateur"
     *  , requirements={
     *      {
     *          "name"="id",
     *          "dataType"="int",
     *          "description"="Paramètres représentant l'id de la réservation désirée ainsi que le token ex : {'token':'entrezvotretoken', 'id':12]"
     *      }
     *  }
     *  , output="MainBundle\Entity\Reservation"
     * )
     * @Rest\View()
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Post("/reservation/get")
     */
    public function getMyReservationAction(Request $request)
    {
        //On récupère le token en request
        $values = json_decode($request->getContent(), true);
        //On décode le token pour récupérer les informations du user
        $decoder = $this->get('lexik_jwt_authentication.encoder.default');
        $payload = $decoder->decode($values['token']);
        
        $reservation = $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->find($values['reservation_id']);
        
        //On vérifie que le user est le bon
        if ($reservation->getEmail() != $payload['username']) {
            throw new \InvalidArgumentException('Ce user n\'as pas les droits');
        } 
        
        //retourne une réservation
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->find($values['reservation_id']);
    }    
    
    /**
     * @ApiDoc(
     *  description="Retourne une liste de Reservations pour un simple utilisateur"
     *  , requirements={
     *      {
     *          "name"="request",
     *          "dataType"="Symfony\Component\HttpFoundation\Request",
     *          "description"="Paramètres représentant le token de l'utilisateur statut ex : entrezvotretoken"
     *      }
     *  }
     *  , output={ "class"=Reservation::class, "collection"=true }
     * )
     * @Rest\View()
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Post("/reservation/mylist")
     */
    public function getMyListReservationsAction(Request $request)
    {
        //On récupère le token en request
        $token = $request->getContent();
        //On décode le token pour récupérer les informations du user
        $decoder = $this->get('lexik_jwt_authentication.encoder.default');
        $payload = $decoder->decode($token);
        
        //retourne la liste complète
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->findMyReservations($payload['username']);
    }

    /**
     * @ApiDoc(
     *  description="Change le statut d'une réservation"
     *  , requirements={
     *      {
     *          "name"="request",
     *          "dataType"="Symfony\Component\HttpFoundation\Request",
     *          "description"="Paramètres représentant l'id réservation plus le statut annulé ex : { id: 41, statut: 'Annulée' }"
     *      }
     *  }
     *  , output="MainBundle\Entity\Reservation"
     * )
     * @Rest\View()
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Put("/reservation/cancel")
     */
    public function putCancelReservationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $jsonResponse = json_decode($request->getContent(), true);

        $reservation = $this->getDoctrine()->getRepository('MainBundle:Reservation')->find($jsonResponse['id']);
        
        //Mise à jour de la date et du statut
        $reservation->setDateDerMaj(new \DateTime());
        $reservation->setStatut('Annulée');
        
        $em->flush();
        
        //Stockage du mail dans le spool
        $mailManager = new MailManager($this->container);
        $mailManager->sendMailToAdminAnnulationReservation($reservation); 
        
        return $reservation ;
    }

    /**
     * @ApiDoc(
     *  description="Retourne des créneaux de réservation"
     *  , requirements={
     *      {
     *          "name"="request",
     *          "dataType"="Symfony\Component\HttpFoundation\Request",
     *          "description"="Paramètres représentant le mois et l'année ex : { annee: 2017, mois: 10 }"
     *      }
     *  }
     *  , output={ "class"=Reservation::class, "collection"=true }
     * )
     * @Rest\View()
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Post("reservation/creneauxbyanneemois")
     */
    public function getCreneauxbyanneemoisAction(Request $request)
    {
        $jsonResponse = json_decode($request->getContent(), true);
        
        //Retourne la liste complète
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->findCreneauxByAnneeMois($jsonResponse['annee'],$jsonResponse['mois']);
    }
    
    /**
     * @ApiDoc(
     *  description="Crée une reservation en fonction du JSON reçu"
     *  , requirements={
     *      {
     *          "name"="request",
     *          "dataType"="Symfony\Component\HttpFoundation\Request",
     *          "description"="Request contenant un objet Reservation"
     *      }
     *  }
     *  , output="MainBundle\Entity\Reservation"
     * )
     * @Rest\View()
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Post("/reservation/create")
     */
    public function createReservationAction(Request $request)
    {
        //Initialisation du Serializer
        $normalizer = new BoardNormalizer();
        $encoder = new JsonEncoder();
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
        $newReservation->setIsFeedbackable(false);
        $newReservation->setDateCreation(new \DateTime());
        $newReservation->setDateDerMaj(new \DateTime());
        
        //On insere puis on commit
        $em = $this->getDoctrine()->getManager();
        $em->persist($newReservation);
        $em->flush();
        
        //Stockage du mail dans le spool
        $mailManager = new MailManager($this->container);
        $mailManager->sendMailToAdminDemandeReservation($newReservation); 
        
        //On renvoie la nouvelle reservation
        return json_encode($newReservation);
    } 
    
    
    
}
