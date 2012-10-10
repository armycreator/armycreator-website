<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\AbstractUnit
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap({"unit" = "Unit", "group" = "UnitGroup"})
 */
class AbstractUnit
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * breed
     * 
     * @var Breed
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Breed", inversedBy="unitList")
     */
    private $breed;

    /**
     * unitType
     * 
     * @var UnitType
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="UnitType", inversedBy="unitList")
     */
    private $unitType;

	/**
	 * unitStuffList
	 * 
	 * @var array<UnitStuff>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="UnitStuff", mappedBy="unit")
	 */
	private $unitStuffList;


    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->unitStuffList = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set name
     *
     * @param string $name
     * @return AbstractUnit
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
     * setBreed
     *
     * @param Breed $breed
     * @access public
     * @return AbstractUnit
     */
    public function setBreed($breed)
    {
        $this->breed = $breed;
        return $this;
    }

    /**
     * getBreed
     *
     * @access public
     * @return Breed
     */
    public function getBreed()
    {
        return $this->breed;
    }

    /**
     * setUnitType
     *
     * @param UnitType $unitType
     * @access public
     * @return AbstractUnit
     */
    public function setUnitType($unitType)
    {
        $this->unitType = $unitType;
        return $this;
    }

    /**
     * getUnitType
     *
     * @access public
     * @return UnitType
     */
    public function getUnitType()
    {
        return $this->unitType;
    }

    /**
     * Add unitStuffList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff $unitStuffList
     * @return AbstractUnit
     */
    public function addUnitStuffList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff $unitStuffList)
    {
        $this->unitStuffList[] = $unitStuffList;
    
        return $this;
    }

    /**
     * Remove unitStuffList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff $unitStuffList
     */
    public function removeUnitStuffList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff $unitStuffList)
    {
        $this->unitStuffList->removeElement($unitStuffList);
    }

    /**
     * Get unitStuffList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUnitStuffList()
    {
        return $this->unitStuffList;
    }
}