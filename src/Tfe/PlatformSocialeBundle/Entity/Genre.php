<?php

namespace Tfe\PlatformSocialeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 * @ORM\Table(name="genre")
 * @ORM\Entity(repositoryClass="Tfe\PlatformSocialeBundle\Repository\GenreRepository")
 */
class Genre
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
     * @ORM\Column(name="nameGenre", type="string", length=255)
     */
    private $nameGenre;


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
     * Set nameGenre
     *
     * @param string $nameGenre
     *
     * @return Genre
     */
    public function setNameGenre($nameGenre)
    {
        $this->nameGenre = $nameGenre;

        return $this;
    }

    /**
     * Get nameGenre
     *
     * @return string
     */
    public function getNameGenre()
    {
        return $this->nameGenre;
    }
}
