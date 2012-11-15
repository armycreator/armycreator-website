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
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->unitHasUnitGroupList = new \Doctrine\Common\Collections\ArrayCollection();
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
}
