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

//Ne pas supprimer sont utilisés dans les annotations
use FOS\RestBundle\Controller\Annotations as Rest;
use  Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Controller pour les réservations
 * @package MainBundle\Controller
 * @author Maxime Bourdel
 */
class ReservationController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc(
     *  description="Retourne une liste de Reservations pour un simple utilisateur"
     *  , requirements={
     *      {
     *          "name"="request",
     *          "dataType"="Symfony\Component\HttpFoundation\Request",
     *          "description"="Paramètres représentant l'email de l'utilisateur statut ex : {email: 'maximebourdel@businessdecision.com'}"
     *      }
     *  }
     *  , output={ "class"=Reservation::class, "collection"=true }
     * )
     * @Rest\View()
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
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
     */
    public function putCancelAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $jsonResponse = json_decode($request->getContent(), true);

        $reservation = $this->getDoctrine()->getRepository('MainBundle:Reservation')->find($jsonResponse['id']);
        //Mise à jour de la date
        $reservation->setDateDerMaj(new \DateTime());
        
        $updateReservation = $reservation->setStatut('Annulée');
        
        $em->flush();
        
        //Envoi du mail en spool
        $mailManager = new MailManager($this->container);
        $mailManager->sendMailToAdminAnnulationReservation($reservation); 
        
        return $updateReservation ;
    }
    
    /**
     *  description="Retourne une liste de Reservation"
     *  , output={ "class"=Reservation::class, "collection"=true }
     * )
     * @Rest\View()
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getSumdaybydayAction()
    {
        //Retourne la liste complète
        return $this->getDoctrine()
                    ->getRepository('MainBundle:Reservation')
                    ->findSumReservationsDayByDay();
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
