<?php

namespace Tfe\PlatformSocialeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

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
     ** @ORM\ManyToOne(targetEntity="Tfe\UserBundle\Entity\Users", cascade={"persist"}, inversedBy="publication")
     ** @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     ** @ORM\ManyToMany(targetEntity="Tfe\PlatformSocialeBundle\Entity\Genre", cascade={"persist"})
     *
     */
    private $genres;

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
     * @var Date
     *
     * @ORM\Column(name="date_publication", type="date", nullable=true)
     */
    private $datePublication;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Tfe\PlatformSocialeBundle\Entity\CommentPublication", mappedBy="publication", cascade={"persist", "remove"})
     */
    private $comment;

    public function __construct()
    {
        $this->createdAt = new \Datetime();
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * Set id
     *
     * @param int $id
     *
     * @return Publication
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
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
    public function setCreatedAt(\DateTime $createdAt)
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

   

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Publication
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set user
     *
     * @param \Tfe\UserBundle\Entity\Users $user
     *
     * @return Publication
     */
    public function setUser(\Tfe\UserBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Tfe\UserBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add genre
     *
     * @param \Tfe\PlatformSocialeBundle\Entity\Genre $genre
     *
     * @return Publication
     */
    public function addGenre(\Tfe\PlatformSocialeBundle\Entity\Genre $genre)
    {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param \Tfe\PlatformSocialeBundle\Entity\Genre $genre
     */
    public function removeGenre(\Tfe\PlatformSocialeBundle\Entity\Genre $genre)
    {
        $this->genres->removeElement($genre);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Add comment
     *
     * @param \Tfe\PlatformSocialeBundle\Entity\CommentPublication $comment
     *
     * @return Publication
     */
    public function addComment(\Tfe\PlatformSocialeBundle\Entity\CommentPublication $comment)
    {
        $this->comment[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \Tfe\PlatformSocialeBundle\Entity\CommentPublication $comment
     */
    public function removeComment(\Tfe\PlatformSocialeBundle\Entity\CommentPublication $comment)
    {
        $this->comment->removeElement($comment);
    }

    /**
     * Get comment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComment()
    {
        return $this->comment;
    }
}
