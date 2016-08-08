<?php

namespace Tfe\PlatformSocialeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity(repositoryClass="Tfe\PlatformSocialeBundle\Repository\PublicationRepository")
 */
class Publication
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
     * @ORM\Column(name="userId", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="genreId", type="integer", nullable=true)
     */
    private $genreId;

    /**
     * @var string
     *
     * @ORM\Column(name="titrePublication", type="string", length=255, nullable=true)
     */
    private $titrePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="contentPublication", type="text", nullable=true)
     */
    private $contentPublication;

    /**
     * @var string
     *
     * @ORM\Column(name="motsCles", type="string", length=255, nullable=true)
     */
    private $motsCles;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Publication
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set genreId
     *
     * @param integer $genreId
     *
     * @return Publication
     */
    public function setGenreId($genreId)
    {
        $this->genreId = $genreId;

        return $this;
    }

    /**
     * Get genreId
     *
     * @return int
     */
    public function getGenreId()
    {
        return $this->genreId;
    }

    /**
     * Set titrePublication
     *
     * @param string $titrePublication
     *
     * @return Publication
     */
    public function setTitrePublication($titrePublication)
    {
        $this->titrePublication = $titrePublication;

        return $this;
    }

    /**
     * Get titrePublication
     *
     * @return string
     */
    public function getTitrePublication()
    {
        return $this->titrePublication;
    }

    /**
     * Set contentPublication
     *
     * @param string $contentPublication
     *
     * @return Publication
     */
    public function setContentPublication($contentPublication)
    {
        $this->contentPublication = $contentPublication;

        return $this;
    }

    /**
     * Get contentPublication
     *
     * @return string
     */
    public function getContentPublication()
    {
        return $this->contentPublication;
    }

  

    


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Publication
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Publication
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set motsCles
     *
     * @param string $motsCles
     *
     * @return Publication
     */
    public function setMotsCles($motsCles)
    {
        $this->motsCles = $motsCles;

        return $this;
    }

    /**
     * Get motsCles
     *
     * @return string
     */
    public function getMotsCles()
    {
        return $this->motsCles;
    }
}
