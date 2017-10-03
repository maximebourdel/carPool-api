<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="admin", options={"comment":"Table listant les administrateurs de l'application"})
 * @ORM\Entity(repositoryClass="MainBundle\Repository\AdminRepository")
 * 
 * @package MainBundle\Entity
 * @author Maxime Bourdel
 */
class Admin
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"comment":"Identifiant technique unique de l'admin"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true, options={"comment":"Adresse email de l'admin représente une clé unique"})
     */
    private $email;

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
     * Set email
     *
     * @param string $email
     *
     * @return Admin
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

}

