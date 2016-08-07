<?php

namespace Tfe\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Tfe\ForumBundle\Repository\CategoryRepository")
 */
class Category
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true, unique=true)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="author_id", type="integer", unique=true, nullable=true)
     */
    private $authorId;

    /**
     ** @ORM\ManyToOne(targetEntity="Tfe\ForumBundle\Entity\Groupe", cascade={"persist"}, inversedBy="category")
     ** @ORM\JoinColumn(nullable=false)
     */
    private $groupe;


   

   

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set authorId
     *
     * @param integer $authorId
     *
     * @return Category
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * Get authorId
     *
     * @return integer
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * Set groupe
     *
     * @param \Tfe\ForumBundle\Entity\Groupe $groupe
     *
     * @return Category
     */
    public function setGroupe(\Tfe\ForumBundle\Entity\Groupe $groupe)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \Tfe\ForumBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }
}
