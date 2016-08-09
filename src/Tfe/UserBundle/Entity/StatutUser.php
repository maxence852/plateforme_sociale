<?php

namespace Tfe\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatutUser
 *
 * @ORM\Table(name="statut_user")
 * @ORM\Entity(repositoryClass="Tfe\UserBundle\Repository\StatutUserRepository")
 */
class StatutUser
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
     * @var int
     *
     * @ORM\Column(name="valeurStatut", type="integer")
     */
    private $valeurStatut;

    /**
     * @var string
     *
     * @ORM\Column(name="nameStatut", type="string", length=255)
     */
    private $nameStatut;


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
     * Set valeurStatut
     *
     * @param integer $valeurStatut
     *
     * @return StatutUser
     */
    public function setValeurStatut($valeurStatut)
    {
        $this->valeurStatut = $valeurStatut;

        return $this;
    }

    /**
     * Get valeurStatut
     *
     * @return int
     */
    public function getValeurStatut()
    {
        return $this->valeurStatut;
    }

    /**
     * Set nameStatut
     *
     * @param string $nameStatut
     *
     * @return StatutUser
     */
    public function setNameStatut($nameStatut)
    {
        $this->nameStatut = $nameStatut;

        return $this;
    }

    /**
     * Get nameStatut
     *
     * @return string
     */
    public function getNameStatut()
    {
        return $this->nameStatut;
    }
}

