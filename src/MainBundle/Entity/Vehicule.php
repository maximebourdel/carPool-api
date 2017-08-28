<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vehicule
 *
 * @ORM\Table(name="vehicule")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\VehiculeRepository")
 */
class Vehicule
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="immatriculation", type="string", length=9, unique=true)
     */
    private $immatriculation;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_premiere_immatriculation", type="date", nullable=true)
     */
    private $datePremiereImmatriculation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_arrivee_vehicule_bd", type="date", nullable=true)
     */
    private $dateArriveeVehiculeBd;

    /**
     * @var string
     *
     * @ORM\Column(name="type_acquisition", type="string", length=25)
     */
    private $typeAcquisition;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_responsable", type="string", length=255)
     */
    private $nomResponsable;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=100)
     */
    private $marque;

    /**
     * @var int
     *
     * @ORM\Column(name="kilometrage", type="integer")
     */
    private $kilometrage;

    /**
     * @var string
     *
     * @ORM\Column(name="derniere_revision", type="string", length=100)
     */
    private $derniereRevision;
    
    /**
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Reservation", mappedBy="vehicule")
     */
    private $reservations;

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
     * Set immatriculation
     *
     * @param string $immatriculation
     *
     * @return Vehicule
     */
    public function setImmatriculation($immatriculation)
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    /**
     * Get immatriculation
     *
     * @return string
     */
    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Vehicule
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set datePremiereImmatriculation
     *
     * @param \DateTime $datePremiereImmatriculation
     *
     * @return Vehicule
     */
    public function setDatePremiereImmatriculation($datePremiereImmatriculation)
    {
        $this->datePremiereImmatriculation = $datePremiereImmatriculation;

        return $this;
    }

    /**
     * Get datePremiereImmatriculation
     *
     * @return \DateTime
     */
    public function getDatePremiereImmatriculation()
    {
        return $this->datePremiereImmatriculation;
    }

    /**
     * Set dateArriveeVehiculeBd
     *
     * @param \DateTime $dateArriveeVehiculeBd
     *
     * @return Vehicule
     */
    public function setDateArriveeVehiculeBd($dateArriveeVehiculeBd)
    {
        $this->dateArriveeVehiculeBd = $dateArriveeVehiculeBd;

        return $this;
    }

    /**
     * Get dateArriveeVehiculeBd
     *
     * @return \DateTime
     */
    public function getDateArriveeVehiculeBd()
    {
        return $this->dateArriveeVehiculeBd;
    }

    /**
     * Set typeAcquisition
     *
     * @param string $typeAcquisition
     *
     * @return Vehicule
     */
    public function setTypeAcquisition($typeAcquisition)
    {
        $this->typeAcquisition = $typeAcquisition;

        return $this;
    }

    /**
     * Get typeAcquisition
     *
     * @return string
     */
    public function getTypeAcquisition()
    {
        return $this->typeAcquisition;
    }

    /**
     * Set nomResponsable
     *
     * @param string $nomResponsable
     *
     * @return Vehicule
     */
    public function setNomResponsable($nomResponsable)
    {
        $this->nomResponsable = $nomResponsable;

        return $this;
    }

    /**
     * Get nomResponsable
     *
     * @return string
     */
    public function getNomResponsable()
    {
        return $this->nomResponsable;
    }

    /**
     * Set marque
     *
     * @param string $marque
     *
     * @return Vehicule
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set kilometrage
     *
     * @param integer $kilometrage
     *
     * @return Vehicule
     */
    public function setKilometrage($kilometrage)
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    /**
     * Get kilometrage
     *
     * @return int
     */
    public function getKilometrage()
    {
        return $this->kilometrage;
    }

    /**
     * Set derniereRevision
     *
     * @param string $derniereRevision
     *
     * @return Vehicule
     */
    public function setDerniereRevision($derniereRevision)
    {
        $this->derniereRevision = $derniereRevision;

        return $this;
    }

    /**
     * Get derniereRevision
     *
     * @return string
     */
    public function getDerniereRevision()
    {
        return $this->derniereRevision;
    }    
    
    /**
     * Ajouter une nouvelle Reservation
     * 
     * @param \MainBundle\Entity\Reservation $reservation
     */
    public function addVehicule(\MainBundle\Entity\Reservation $reservation)	{
        $this->reservations[] = $reservation;
    }

    /**
     * Enlever une Reservation existante
     * 
     * @param \MainBundle\Entity\Reservation $reservation
     */
    public function removeVehicule(\MainBundle\Entity\Reservation $reservation)	{
        $this->reservations->removeElement($reservation);
    }
    
}

