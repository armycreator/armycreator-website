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
     * @var integer $unitNumber
     *
     * @ORM\Column(name="unitNumber", type="integer")
     */
    private $unitNumber;

    /**
     * unit
     *
     * @var Unit
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Unit", inversedBy="unitHasUnitGroupList")
     */
    private $unit;

    /**
     * group
     *
     * @var UnitGroup
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="UnitGroup", inversedBy="unitHasUnitGroupList")
     */
    private $group;

    /**
     * importedId
     *
     * @ORM\Column(type="integer", nullable=true)
     * @var mixed
     * @access private
     */
    private $importedId;

    /**
     * mainUnit
     *
     * @ORM\Column(type="boolean")
     * @var boolean
     * @access private
     */
    private $mainUnit;

    /**
     * canChooseNumber
     *
     * @ORM\Column(type="boolean")
     * @var boolean
     * @access private
     */
    private $canChooseNumber;

    /**
     * position
     *
     * @var int
     * @access private
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->setMainUnit(false)
            ->setCanChooseNumber(true)
            ->setUnitNumber(1);

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
     * Set unitNumber
     *
     * @param integer $unitNumber
     * @return UnitHasUnitGroup
     */
    public function setUnitNumber($unitNumber)
    {
        $this->unitNumber = $unitNumber;

        return $this;
    }

    /**
     * Get unitNumber
     *
     * @return integer
     */
    public function getUnitNumber()
    {
        return $this->unitNumber;
    }

    /**
     * Set unit
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unit
     * @return UnitHasUnitGroup
     */
    public function setUnit(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unit = null)
    {
        $unit->addUnitHasUnitGroupList($this);
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
        $group->addUnitHasUnitGroupList($this);
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

    /**
     * Set importedId
     *
     * @param integer $importedId
     * @return UnitHasUnitGroup
     */
    public function setImportedId($importedId)
    {
        $this->importedId = $importedId;

        return $this;
    }

    /**
     * Get importedId
     *
     * @return integer
     */
    public function getImportedId()
    {
        return $this->importedId;
    }

    /**
     * Set mainUnit
     *
     * @param boolean $mainUnit
     * @return UnitHasUnitGroup
     */
    public function setMainUnit($mainUnit)
    {
        $this->mainUnit = $mainUnit;

        return $this;
    }

    /**
     * Get mainUnit
     *
     * @return boolean
     */
    public function getMainUnit()
    {
        return $this->mainUnit;
    }

    /**
     * Set canChooseNumber
     *
     * @param boolean $canChooseNumber
     * @return UnitHasUnitGroup
     */
    public function setCanChooseNumber($canChooseNumber)
    {
        $this->canChooseNumber = $canChooseNumber;

        return $this;
    }

    /**
     * Get canChooseNumber
     *
     * @return boolean
     */
    public function getCanChooseNumber()
    {
        return $this->canChooseNumber;
    }

    /**
     * Gets the value of position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the value of position
     *
     * @param int $position position
     *
     * @return UnitHasUnitGroup
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }
}
