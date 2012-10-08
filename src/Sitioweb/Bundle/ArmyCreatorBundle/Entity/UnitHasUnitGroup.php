<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UnitHasUnitGroup
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
     * @var integer $number
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * unit
     * 
     * @var Unit
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Unit", inversedBy="unitHasGroupList")
     */
    private $unit;

    /**
     * group
     * 
     * @var UnitGroup
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="UnitGroup", inversedBy="unitHasGroupList")
     */
    private $group;

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
     * Set number
     *
     * @param integer $number
     * @return UnitHasUnitGroup
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set unit
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unit
     * @return UnitHasUnitGroup
     */
    public function setUnit(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set group
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup $group
     * @return UnitHasUnitGroup
     */
    public function setGroup(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup $group = null)
    {
        $this->group = $group;
    
        return $this;
    }

    /**
     * Get group
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }
}