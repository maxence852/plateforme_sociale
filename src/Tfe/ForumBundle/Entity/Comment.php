<?php

namespace Tfe\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="forum_comment")
 * @ORM\Entity(repositoryClass="Tfe\ForumBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    

    /**
     ** @ORM\ManyToOne(targetEntity="Tfe\ForumBundle\Entity\Thread",cascade={"persist"}, inversedBy="comment")
     ** @ORM\JoinColumn(nullable=false)
     */
    private $thread;

    /**
     ** @ORM\ManyToOne(targetEntity="Tfe\UserBundle\Entity\Users", cascade={"persist"}, inversedBy="comment")
     ** @ORM\JoinColumn(nullable=true)
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
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
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable= true)
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
     * Set body
     *
     * @param string $body
     *
     * @return Comment
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }



    /**
     * Set threadId
     *
     * @param integer $threadId
     *
     * @return Comment
     */
    public function setThreadId($threadId)
    {
        $this->threadId = $threadId;

        return $this;
    }
    

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Comment
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
     * @return Comment
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
     * Set thread
     *
     * @param \Tfe\ForumBundle\Entity\Thread $thread
     *
     * @return Comment
     */
    public function setThread(\Tfe\ForumBundle\Entity\Thread $thread)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Tfe\ForumBundle\Entity\Thread
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set author
     *
     * @param \Tfe\UserBundle\Entity\Users $author
     *
     * @return Comment
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
