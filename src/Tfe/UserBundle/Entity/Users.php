<?php

namespace Tfe\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Users
 *
 * @ORM\Table(name="tfe_users")
 * @ORM\Entity(repositoryClass="Tfe\UserBundle\Repository\UsersRepository")
 */
class Users extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /** Variable pour édition Users*/

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The firstname is too short.",
     *     maxMessage="The firstname is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The sex is too short.",
     *     maxMessage="The sex is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $gender;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\Length(
     *     min=1,
     *     max=255,
     *     minMessage="The age is too short.",
     *     maxMessage="The age is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $age;


    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\Length(
     *     min=1,
     *     max=255,
     *     minMessage="The country is too short.",
     *     maxMessage="The country is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $country;


    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="The language is too short.",
     *     maxMessage="The language is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $language;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The website is too short.",
     *     maxMessage="The website is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $web_site;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The facebook account is too short.",
     *     maxMessage="The facebook account is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $facebook_account;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The twitter account is too short.",
     *     maxMessage="The twitter account is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $twitter_account;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\NotBlank(message="Please enter your description.", groups={"Registration": "Profile"})
     * @Assert\Length(
     *     min=null,
     *     max=255,
     *     minMessage="The description is too short.",
     *     maxMessage="The description is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $description_user;


    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The signature is too short.",
     *     maxMessage="The signature is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $signature;


    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The read level is too short.",
     *     maxMessage="The read level is too long.",
     *     groups={"Registration","Profile"}
     * )
     */
    protected $read_level;

    /** @ORM\Column(name="user_point", type="integer", nullable=true) */
    protected $userPoint;

    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;




    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;



    /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
    protected $google_id;


    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;
    

    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return Users
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     *
     * @return Users
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     *
     * @return Users
     */
    public function setGoogleId($googleId)
    {
        $this->google_id = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * Set googleAccessToken
     *
     * @param string $googleAccessToken
     *
     * @return Users
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->google_access_token = $googleAccessToken;

        return $this;
    }

    /**
     * Get googleAccessToken
     *
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Users
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Users
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }



    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Users
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set age
     *
     * @param string $age
     *
     * @return Users
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return string
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Users
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Users
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set webSite
     *
     * @param string $webSite
     *
     * @return Users
     */
    public function setWebSite($webSite)
    {
        $this->web_site = $webSite;

        return $this;
    }

    /**
     * Get webSite
     *
     * @return string
     */
    public function getWebSite()
    {
        return $this->web_site;
    }

    /**
     * Set facebookAccount
     *
     * @param string $facebookAccount
     *
     * @return Users
     */
    public function setFacebookAccount($facebookAccount)
    {
        $this->facebook_account = $facebookAccount;

        return $this;
    }

    /**
     * Get facebookAccount
     *
     * @return string
     */
    public function getFacebookAccount()
    {
        return $this->facebook_account;
    }

    /**
     * Set twitterAccount
     *
     * @param string $twitterAccount
     *
     * @return Users
     */
    public function setTwitterAccount($twitterAccount)
    {
        $this->twitter_account = $twitterAccount;

        return $this;
    }

    /**
     * Get twitterAccount
     *
     * @return string
     */
    public function getTwitterAccount()
    {
        return $this->twitter_account;
    }

    /**
     * Set descriptionUser
     *
     * @param string $descriptionUser
     *
     * @return Users
     */
    public function setDescriptionUser($descriptionUser)
    {
        $this->description_user = $descriptionUser;

        return $this;
    }

    /**
     * Get descriptionUser
     *
     * @return string
     */
    public function getDescriptionUser()
    {
        return $this->description_user;
    }

    /**
     * Set signature
     *
     * @param string $signature
     *
     * @return Users
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Set readLevel
     *
     * @param string $readLevel
     *
     * @return Users
     */
    public function setReadLevel($readLevel)
    {
        $this->read_level = $readLevel;

        return $this;
    }

    /**
     * Get readLevel
     *
     * @return string
     */
    public function getReadLevel()
    {
        return $this->read_level;
    }

    /**
     * Set userPoint
     *
     * @param integer $userPoint
     *
     * @return Users
     */
    public function setUserPoint($userPoint)
    {
        $this->userPoint = $userPoint;

        return $this;
    }

    /**
     * Get userPoint
     *
     * @return integer
     */
    public function getUserPoint()
    {
        return $this->userPoint;
    }
}
