<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", options={"comment":"Liste des réservations de voitures de pool"})
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ReservationRepository")
 * @UniqueEntity(fields={"vehicule", "dateDebut", "dateFin"})
 * 
 * @package MainBundle\Entity
 * @author Maxime Bourdel
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"comment":"Identifiant technique unique de la réservation"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Vehicule", inversedBy="reservations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $vehicule;    

    /**
     * @ORM\OneToOne(targetEntity="MainBundle\Entity\Feedback", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $feedback;      
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, options={"comment":"Email de l'utilisateur ayant fait la réservation (représente l'id unique de l'utilisateur)"})
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, options={"comment":"Nom de famille de l'utilisateur ayant fait la réservation (en majuscule)"})
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, options={"comment":"Prénom de l'utilisateur ayant fait la réservation"})
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="datetime", options={"comment":"Jour ou le véhicule sera récupéré par le demandeur"})
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="datetime", options={"comment":"Jour ou le véhicule sera rendu par le demandeur"})
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=100, options={"comment":"Statut de la réservation peut-être annulée, en attente confirmé ou autres..."})
     */
    private $statut;

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
     * Set vehicule
     *
     * @param \MainBundle\Entity\Vehicule $vehicule
     *
     * @return Reservation
     */
    public function setVehicule($vehicule)
    {
        $this->vehicule = $vehicule;

        return $this;
    }      
    
    /**
     * Get vehicule
     *
     * @return \MainBundle\Entity\Vehicule
     */
    public function getVehicule()
    {
        return $this->vehicule;
    }
 
    /**
     * Set feedback
     *
     * @param \MainBundle\Entity\Feedback $feedback
     *
     * @return Reservation
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;

        return $this;
    }      
    
    /**
     * Get feedback
     *
     * @return \MainBundle\Entity\Feedback
     */
    public function getFeedback()
    {
        return $this->feedback;
    }    
    
    /**
     * Set email
     *
     * @param string $email
     *
     * @return Reservation
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
   
    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Reservation
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Reservation
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Reservation
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Reservation
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }
    
    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Reservation
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
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

