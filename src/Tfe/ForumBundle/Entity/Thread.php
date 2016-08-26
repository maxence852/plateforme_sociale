<?php

namespace Tfe\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Thread
 *
 * @ORM\Table(name="forum_thread")
 * @ORM\Entity(repositoryClass="Tfe\ForumBundle\Repository\ThreadRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Thread
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="author_id", type="integer")
     */
    private $authorId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
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
     * @ORM\Column(name="updateAt", type="datetime")
     */
    private $updateAt;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=255)
     */
    private $body;

    /**
     ** @ORM\ManyToOne(targetEntity="Tfe\ForumBundle\Entity\Category", cascade={"persist"}, inversedBy="thread")
     ** @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /*
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer")

    private $groupId;
*/


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
     * @return Thread
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
     * @return Thread
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
     * @return Thread
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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Thread
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Thread
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
     * Set category
     *
     * @param \Tfe\ForumBundle\Entity\Category $category
     *
     * @return Thread
     */
    public function setCategory(\Tfe\ForumBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Tfe\ForumBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
