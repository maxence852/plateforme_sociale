<?php

namespace Tfe\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="forum_category")
 * @ORM\Entity(repositoryClass="Tfe\ForumBundle\Repository\CategoryRepository")
 * @ORM\HasLifecycleCallbacks
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
     ** @ORM\ManyToOne(targetEntity="Tfe\UserBundle\Entity\Users", cascade={"persist"}, inversedBy="category")
     ** @ORM\JoinColumn(nullable=true)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="Tfe\ForumBundle\Entity\Thread", mappedBy="category", cascade={"persist", "remove"})
     */
    private $thread;

    /**
     ** @ORM\ManyToOne(targetEntity="Tfe\ForumBundle\Entity\Groupe", cascade={"persist"}, inversedBy="category")
     ** @ORM\JoinColumn(nullable=false)
     */
    private $groupe;


    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \Datetime();
    }

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;
   

   

    

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Category
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
     * @return Category
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
     * Add thread
     *
     * @param \Tfe\ForumBundle\Entity\Thread $thread
     *
     * @return Category
     */
    public function addThread(\Tfe\ForumBundle\Entity\Thread $thread)
    {
        $this->thread[] = $thread;
        $thread->setCategory($this);
        return $this;
    }

    /**
     * Remove thread
     *
     * @param \Tfe\ForumBundle\Entity\Thread $thread
     */
    public function removeThread(\Tfe\ForumBundle\Entity\Thread $thread)
    {
        $this->thread->removeElement($thread);
    }

    /**
     * Get thread
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThread()
    {
        return $this->thread;
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

    /**
     * Set author
     *
     * @param \Tfe\UserBundle\Entity\Users $author
     *
     * @return Category
     */
    public function setAuthor(\Tfe\UserBundle\Entity\Users $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Tfe\UserBundle\Entity\Users
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
