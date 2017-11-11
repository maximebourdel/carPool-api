<?php

namespace MainBundle\Repository;

/**
 * VehiculeRepository
 *
 * @package MainBundle\Repository
 * @author Maxime Bourdel
 */
class VehiculeRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Retourne le véhicule dispos pour une ville donnée
     * pour une période donnée ayant le moins de kilomètres
     * Exemple pour nantes entre le 1er janvier et le 2 février
     * SELECT 
     *       vehicul.*
     *   FROM vehicule vehicul 
     *   WHERE vehicul.id not in (	
     *       SELECT vehi.id
     *       FROM 
     *           vehicule vehi
     *               LEFT JOIN reservation res
     *                   ON res.vehicule_id = vehi.id and res.statut != 'Annulée'
     *               , calendrier cal                            
     *       WHERE 
     *           cal.date between DATE('2017-01-01') and DATE('2017-01-01')  
     *           AND ( 
     *               DATE('2017-01-01') between res.date_debut and res.date_fin 
     *               OR DATE('2017-02-02') between res.date_debut and res.date_fin 
     *               OR res.date_debut between DATE('2017-01-01') and DATE('2017-02-02')
     *               OR res.date_fin between DATE('2017-01-01') and DATE('2017-02-02')
     *           
     *           )
     *       GROUP BY vehi.id
     *   ) 
     *   AND vehicul.ville = 'Nantes' 
     *   ORDER BY vehicul.kilometrage ASC
     * 
     * @param string $dateDebut
     * @param string $dateFin
     * @param string $ville
     * @return array
     */
    public function findVehiculeDispo($dateDebut, $dateFin, $ville)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT 
                    vehicul 
                FROM MainBundle:Vehicule vehicul 
                WHERE vehicul.id not in (	
                    SELECT vehi.id
                    FROM 
                        MainBundle:Vehicule vehi
                            LEFT JOIN MainBundle:Reservation res
                                WITH res.vehicule = vehi.id and res.statut != \'Annulée\'
                            , MainBundle:Calendrier cal                            
                    WHERE 
                        cal.date between DATE(\''. $dateDebut .'\') and DATE(\''. $dateFin .'\')  
                        AND ( 
                            DATE(\''. $dateDebut .'\') between res.dateDebut and res.dateFin 
                            OR DATE(\''. $dateFin .'\') between res.dateDebut and res.dateFin 
                            OR res.dateDebut between DATE(\''. $dateDebut .'\') and DATE(\''. $dateFin .'\') 
                            OR res.dateFin between DATE(\''. $dateDebut .'\') and DATE(\''. $dateFin .'\') 
                        )
                    GROUP BY vehi.id
                ) 
                AND vehicul.ville =\''. $ville .'\' 
                ORDER BY vehicul.kilometrage ASC'
            )->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
