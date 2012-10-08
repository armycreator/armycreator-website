<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UnitType
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
	 * unitList
	 * 
	 * @var array<Unit>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="Unit", mappedBy="unitType")
	 */
	private $unitList;


    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->unitList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return UnitType
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
     * Add unitList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unitList
     * @return UnitType
     */
    public function addUnitList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unitList)
    {
        $this->unitList[] = $unitList;
    
        return $this;
    }

    /**
     * Remove unitList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unitList
     */
    public function removeUnitList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unitList)
    {
        $this->unitList->removeElement($unitList);
    }

    /**
     * Get unitList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUnitList()
    {
        return $this->unitList;
    }
}