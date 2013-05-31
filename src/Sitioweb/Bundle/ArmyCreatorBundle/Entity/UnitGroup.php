<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UnitGroup extends AbstractUnit
{
    CONST GROUP_TYPE = 'unitGroup';

	/**
	 * unitHasUnitGroupList
	 * 
	 * @var array<UnitHasUnitGroup>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="UnitHasUnitGroup", mappedBy="group")
	 */
	private $unitHasUnitGroupList;

    /**
     * squadList
     * 
     * @var array<Squad>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="Squad", mappedBy="unitGroup")
     */
    private $squadList;


    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->unitHasUnitGroupList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->squadList = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add unitHasUnitGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup $unitHasUnitGroupList
     * @return UnitGroup
     */
    public function addUnitHasUnitGroupList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup $unitHasUnitGroupList)
    {
        $this->unitHasUnitGroupList[] = $unitHasUnitGroupList;
    
        return $this;
    }

    /**
     * Remove unitHasUnitGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup $unitHasUnitGroupList
     */
    public function removeUnitHasUnitGroupList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup $unitHasUnitGroupList)
    {
        $this->unitHasUnitGroupList->removeElement($unitHasUnitGroupList);
    }

    /**
     * Get unitHasUnitGroupList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUnitHasUnitGroupList()
    {
        return $this->unitHasUnitGroupList;
    }

    /**
     * Add squadList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squadList
     * @return UnitGroup
     */
    public function addSquadList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squadList)
    {
        $this->squadList[] = $squadList;
    
        return $this;
    }

    /**
     * Remove squadList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squadList
     */
    public function removeSquadList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squadList)
    {
        $this->squadList->removeElement($squadList);
    }

    /**
     * Get squadList
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSquadList()
    {
        return $this->squadList;
    }

    public function getPoints()
    {
        $points = parent::getPoints();

        $unitHasUnitGroupList = $this->getUnitHasUnitGroupList();
        foreach ($unitHasUnitGroupList as $unitHasUnitGroup) {
            $points += $unitHasUnitGroup->getUnit()->getPoints() * $unitHasUnitGroup->getUnitNumber();
        }

        return $points;
    }

    /**
     * createFromUnit
     *
     * @param Unit $unit
     * @static
     * @access public
     * @return UnitGroup
     */
    public static function createFromUnit(Unit $unit)
    {
        $unitGroup = new UnitGroup();
        $unitGroup->setName($unit->getName())
            ->setBreed($unit->getBreed())
            ->setUnitType($unit->getUnitType());

        return $unitGroup;
    }
}
