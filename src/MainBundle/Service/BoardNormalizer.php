<?php

namespace MainBundle\Service;

use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class BoardNormalizer extends GetSetMethodNormalizer
{
    /**
     * Fonction appelée automatiquement lors de l'appel à la class BoardNormalizer
     * @param $data
     * @param $class
     * @param type $format
     * @param array $context
     * @return type
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        //Concernant le vehicule
        if (isset($data['date_arrivee_vehicule_bd'])) {
            $data['dateArriveeVehiculeBd'] = new \DateTime($data['date_arrivee_vehicule_bd']);
        }
        if (isset($data['date_premiere_immatriculation'])) {
            $data['datePremiereImmatriculation'] = new \DateTime($data['date_premiere_immatriculation']);
        }
        
        if (isset($data['date_debut'])) {
            $data['dateDebut'] = new \DateTime($data['date_debut']);
        }
        if (isset($data['date_fin'])) {
            $data['dateFin'] = new \DateTime($data['date_fin']);
        }
        
        return parent::denormalize($data, $class, $format, $context);
    }
}
