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
