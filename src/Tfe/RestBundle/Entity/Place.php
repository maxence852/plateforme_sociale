<?php
namespace Tfe\RestBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="places",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="places_name_unique",columns={"name"})}
 * )
 * @ORM\Entity(repositoryClass="Tfe\RestBundle\Repository\PlaceRepository")
 */
class Place
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $address;

    /**
    * @ORM\OneToMany(targetEntity="Price", mappedBy="place")
    * @var Price[]
    */
    protected $prices;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->prices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add price
     *
     * @param \Tfe\RestBundle\Entity\Price $price
     *
     * @return Place
     */
    public function addPrice(\Tfe\RestBundle\Entity\Price $price)
    {
        $this->prices[] = $price;

        return $this;
    }

    /**
     * Remove price
     *
     * @param \Tfe\RestBundle\Entity\Price $price
     */
    public function removePrice(\Tfe\RestBundle\Entity\Price $price)
    {
        $this->prices->removeElement($price);
    }

    /**
     * Get prices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrices()
    {
        return $this->prices;
    }
}
