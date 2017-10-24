<?php

namespace MainBundle\Repository;

/**
 * ReservationRepository
 *
 * @package MainBundle\Repository
 * @author Maxime Bourdel
 */
class ReservationRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function findMyReservations($email)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT res
                FROM MainBundle:Reservation res
                WHERE 
                    res.email = \''. $email .'\'
                    AND res.statut != \'Annulée\' 
                ORDER BY res.dateCreation DESC'
            )
            ->getResult();
    }

    /**
     * Retourne les creneaux par vehicules pour une annee et un mois donne
     * 
       SELECT 
           vehi.immatriculation
           , cal.jour
           , sum(case when cal.date between res.date_debut and res.date_fin then 1 else 0 end ) is_reserve
           , max(case when cal.date between res.date_debut and res.date_fin then res.nom else null end ) nom
           , max(case when cal.date between res.date_debut and res.date_fin then res.prenom else null end ) prenom
           , max(vehi.ville) ville
       FROM calendrier cal, vehicule vehi
           LEFT JOIN reservation res on vehi.id = res.vehicule_id
               AND res.statut != 'Annulée' 
       WHERE cal.annee = 2017 AND cal.mois = 09 
       GROUP BY vehi.immatriculation, cal.jour
       ORDER BY vehi.immatriculation, cal.jour 
     * @param int $annee année du créneau
     * @param int $mois mois du créneau
     * @return type des créneaux sur un mois
     */
    public function findCreneauxByAnneeMois(int $annee, int $mois)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT 
                    vehi.immatriculation
                    , cal.jour
                    , sum(case when cal.date between res.dateDebut and res.dateFin then 1 else 0 end ) is_reserve
                    , max(case when cal.date between res.dateDebut and res.dateFin then res.nom else \'\' end ) nom 
                    , max(case when cal.date between res.dateDebut and res.dateFin then res.prenom else \'\' end ) prenom 
                    , max(vehi.ville) ville
                FROM MainBundle:Calendrier cal, MainBundle:Vehicule vehi
                    LEFT JOIN vehi.reservations res 
                        WITH res.statut != \'Annulée\' 
                WHERE cal.annee = '. $annee .' AND cal.mois = '. $mois .'
                GROUP BY vehi.immatriculation, cal.jour 
                ORDER BY vehi.immatriculation, cal.jour'
            )
            ->getResult();
    }
    
    /**
     * Retrouve les réservations dont la date de fin
     * 
        SELECT *
        FROM reservation res
        WHERE 
            res.statut = 'Confirmée' 
            AND res.date_fin <= NOW() + 1
            AND res.feedback_id IS NULL
            AND res.is_feedbackable = 0
        ORDER BY res.date_fin ASC
     * @return Reservation
     */
    public function findNotRatedFinishedReservations()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT 
                    res 
                FROM MainBundle:Reservation res 
                WHERE 
                    res.statut = \'Confirmée\' 
                    AND res.dateFin <= NOW() + 1 
                    AND res.feedback IS NULL 
                    AND res.isFeedbackable = 0 
                ORDER BY res.dateFin ASC'
            )
            ->getResult();
    }

}

