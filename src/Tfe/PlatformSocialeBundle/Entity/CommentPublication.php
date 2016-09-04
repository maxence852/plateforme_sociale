<?php

namespace Tfe\PlatformSocialeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentPublication
 *
 * @ORM\Table(name="comment_publication")
 * @ORM\Entity(repositoryClass="Tfe\PlatformSocialeBundle\Repository\CommentPublicationRepository")
 */
class CommentPublication
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
     ** @ORM\ManyToOne(targetEntity="Tfe\UserBundle\Entity\Users", cascade={"persist"}, inversedBy="commentPublication")
     ** @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="userEnabledId", type="integer", nullable=true)
     */
    private $userEnabledId;

    /**
     * @var int
     *
     * @ORM\Column(name="commentParentId", type="integer", nullable=true)
     */
    private $commentParentId;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="crated_at", type="datetime")
     */
    private $createdAt;


    public function __construct()
    {
        $this->createdAt = new \Datetime();
        $this->dateEnabled = new \DateTime();
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnabled", type="datetime")
     */
    private $dateEnabled;

    /**
     ** @ORM\ManyToOne(targetEntity="Tfe\PlatformSocialeBundle\Entity\Publication", cascade={"persist"}, inversedBy="comment")
     ** @ORM\JoinColumn(nullable=false)
     */
    private $publication;
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
     * Set userEnabledId
     *
     * @param integer $userEnabledId
     *
     * @return CommentPublication
     */
    public function setUserEnabledId($userEnabledId)
    {
        $this->userEnabledId = $userEnabledId;

        return $this;
    }

    /**
     * Get userEnabledId
     *
     * @return int
     */
    public function getUserEnabledId()
    {
        return $this->userEnabledId;
    }

    /**
     * Set commentParentId
     *
     * @param integer $commentParentId
     *
     * @return CommentPublication
     */
    public function setCommentParentId($commentParentId)
    {
        $this->commentParentId = $commentParentId;

        return $this;
    }

    /**
     * Get commentParentId
     *
     * @return int
     */
    public function getCommentParentId()
    {
        return $this->commentParentId;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return CommentPublication
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return CommentPublication
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set cratedAt
     *
     * @param \DateTime $createdAt
     * @return CommentPublication
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get cratedAt
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
     * @return CommentPublication
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
     * Set dateEnabled
     *
     * @param \DateTime $dateEnabled
     *
     * @return CommentPublication
     */
    public function setDateEnabled($dateEnabled)
    {
        $this->dateEnabled = $dateEnabled;

        return $this;
    }

    /**
     * Get dateEnabled
     *
     * @return \DateTime
     */
    public function getDateEnabled()
    {
        return $this->dateEnabled;
    }

    /**
     * Set user
     *
     * @param \Tfe\UserBundle\Entity\Users $user
     *
     * @return CommentPublication
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
     * Set publication
     *
     * @param \Tfe\PlatformSocialeBundle\Entity\Publication $publication
     *
     * @return CommentPublication
     */
    public function setPublication(\Tfe\PlatformSocialeBundle\Entity\Publication $publication = null)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return \Tfe\PlatformSocialeBundle\Entity\Publication
     */
    public function getPublication()
    {
        return $this->publication;
    }
}
