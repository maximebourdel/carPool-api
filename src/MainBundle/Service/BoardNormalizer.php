<?php

namespace MainBundle\Service;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use MainBundle\Entity\Vehicule;

class BoardNormalizer extends GetSetMethodNormalizer
{
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
