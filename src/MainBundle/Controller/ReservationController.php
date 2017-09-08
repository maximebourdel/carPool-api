<?php

namespace MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use MainBundle\Entity\Reservation;

use MainBundle\Service\Mailer\Mailer;

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
    public function putStatutAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $jsonResponse = json_decode($request->getContent(), true);

        $reservation = $this->getDoctrine()->getRepository('MainBundle:Reservation')->find($jsonResponse['id']);
        
        $updateReservation = $reservation->setStatut($jsonResponse['statut']);
        
        $em->flush();
        
        /*if($jsonResponse['statut'] == '') {
            $message = (new \Swift_Message('Annulation réservation de '. $newReservation->getEmail()))
                ->setFrom('maxime.bourdel@businessdecision.com')
                ->setTo('maxime.bourdel@businessdecision.com')
                ->setBody(
                    $this->renderView(
                        // app/Resources/views/Emails/registration.html.twig
                       'Emails/demande_annulation.html.twig',
                        array('reservation' => $newReservation)
                    ),
                    'text/html'
                );
        }
        $this->get('mailer')->send($message);*/
        
        
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
		//retourne la liste complète
        
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
        
        //On insere puis on commit
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($newReservation);
        $em->flush();
        
        $message = (new \Swift_Message('Demande de reservation de '. $newReservation->getEmail()))
            ->setFrom('maxime.bourdel@businessdecision.com')
            ->setTo('maxime.bourdel@businessdecision.com')
            ->setBody(
                $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                    'Emails/demande_reservation.html.twig',
                    array('reservation' => $newReservation)
                ),
                'text/html'
            )
        //Envoi du mail en spool
        //Mailer::sendMailDemandeReservation($this, $newReservation);
             
        ;
        
        $this->get('mailer')->send($message);
        
        
        
        //Envoi du mail en spool
        //Mailer::sendMailDemandeReservation($this, $newReservation);
        
        //On renvoie la nouvelle reservation
        return json_encode($newReservation);
    } 
    
    
    
}
