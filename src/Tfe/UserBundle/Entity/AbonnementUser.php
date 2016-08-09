<?php

namespace Tfe\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbonnementUser
 *
 * @ORM\Table(name="abonnement_user")
 * @ORM\Entity(repositoryClass="Tfe\UserBundle\Repository\AbonnementUserRepository")
 */
class AbonnementUser
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
     * @ORM\Column(name="suiveurId", type="integer")
     */
    private $suiveurId;

    /**
     * @var int
     *
     * @ORM\Column(name="suiviId", type="integer")
     */
    private $suiviId;


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
     * Set suiveurId
     *
     * @param integer $suiveurId
     *
     * @return AbonnementUser
     */
    public function setSuiveurId($suiveurId)
    {
        $this->suiveurId = $suiveurId;

        return $this;
    }

    /**
     * Get suiveurId
     *
     * @return int
     */
    public function getSuiveurId()
    {
        return $this->suiveurId;
    }

    /**
     * Set suiviId
     *
     * @param integer $suiviId
     *
     * @return AbonnementUser
     */
    public function setSuiviId($suiviId)
    {
        $this->suiviId = $suiviId;

        return $this;
    }

    /**
     * Get suiviId
     *
     * @return int
     */
    public function getSuiviId()
    {
        return $this->suiviId;
    }
}

