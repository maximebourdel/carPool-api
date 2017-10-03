<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calendrier
 *
 * @ORM\Table(name="calendrier", options={"comment":"Table listant jours de la semaine (à maintenir à jour manuellement)"})
 * @ORM\Entity(repositoryClass="MainBundle\Repository\CalendrierRepository")
 * 
 * @package MainBundle\Entity
 * @author Maxime Bourdel
 */
class Calendrier
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"comment":"Identifiant technique unique de la table calendrier"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", unique=true, options={"comment":"Clé unique représentant la date au format %Y-%m-%d "})
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="jour", type="integer", options={"comment":"Extraction du jour '%d' de l'objet Date"})
     */
    private $jour;

    /**
     * @var int
     *
     * @ORM\Column(name="mois", type="integer", options={"comment":"Extraction du mois '%m' de l'objet Date"})
     */
    private $mois;

    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer", options={"comment":"Extraction de l'année '%Y' de l'objet Date"})
     */
    private $annee;

    /**
     * @var int
     *
     * @ORM\Column(name="semaine", type="integer", options={"comment":"Extraction de la semaine de l'objet Date"})
     */
    private $semaine;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Calendrier
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set jour
     *
     * @param integer $jour
     *
     * @return Calendrier
     */
    public function setJour($jour)
    {
        $this->jour = $jour;

        return $this;
    }

    /**
     * Get jour
     *
     * @return int
     */
    public function getJour()
    {
        return $this->jour;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return Calendrier
     */
    public function setMois($mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return int
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     *
     * @return Calendrier
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return int
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set semaine
     *
     * @param integer $semaine
     *
     * @return Calendrier
     */
    public function setSemaine($semaine)
    {
        $this->semaine = $semaine;

        return $this;
    }

    /**
     * Get semaine
     *
     * @return int
     */
    public function getSemaine()
    {
        return $this->semaine;
    }
}

