<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feedback
 *
 * @ORM\Table(name="feedback", options={"comment":"Table listant les retours à la fin des réservations (Feedbacks)"})
 * @ORM\Entity(repositoryClass="MainBundle\Repository\FeedbackRepository")
 *
 * @package MainBundle\Entity
 * @author Maxime Bourdel
 *  */
class Feedback
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"comment":"Identifiant technique unique du Feedback"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="MainBundle\Entity\Reservation")
     */
    private $reservation;    
    
    /**
     * @var int
     *
     * @ORM\Column(name="kilometres", type="integer", options={"comment":"Kilomètres au compteur du véhicule constaté à la fin de la réservation"})
     */
    private $kilometres;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaires", type="text", nullable=true, options={"comment":"Commentaire sur la réservation ou le véhicule"})
     */
    private $commentaires;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", options={"comment":"Champ technique permettant d'enregistrer la date de d'insertion de la ligne"})
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_der_maj", type="datetime", options={"comment":"Champ technique permettant d'enregistrer la date de dernière modification de la ligne"})
     */
    private $dateDerMaj;    

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set reservation
     *
     * @param \MainBundle\Entity\Reservation $reservation
     *
     * @return Reservation
     */
    public function setReservation($reservation)
    {
        $this->reservation = $reservation;
        return $this;
    }      
    
    /**
     * Get reservation
     *
     * @return \MainBundle\Entity\Reservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }    

    /**
     * Set kilometres
     *
     * @param integer $kilometres
     *
     * @return Feedback
     */
    public function setKilometres($kilometres)
    {
        $this->kilometres = $kilometres;

        return $this;
    }

    /**
     * Get kilometres
     *
     * @return int
     */
    public function getKilometres()
    {
        return $this->kilometres;
    }

    /**
     * Set commentaires
     *
     * @param string $commentaires
     *
     * @return Feedback
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    /**
     * Get commentaires
     *
     * @return string
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
    
    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Reservation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }    
    
    /**
     * Set dateDerMaj
     *
     * @param \DateTime $dateDerMaj
     *
     * @return Reservation
     */
    public function setDateDerMaj($dateDerMaj)
    {
        $this->dateDerMaj = $dateDerMaj;

        return $this;
    }

    /**
     * Get dateDerMaj
     *
     * @return \DateTime
     */
    public function getDateDerMaj()
    {
        return $this->dateDerMaj;
    }    
    
}

