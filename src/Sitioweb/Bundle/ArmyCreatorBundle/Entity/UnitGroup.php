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
	 * unitHasGroupList
	 * 
	 * @var array<UnitHasGroup>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="UnitHasUnitGroup", mappedBy="group")
	 */
	private $unitHasGroupList;


    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->unitHasGroupList = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add unitHasGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasGroup $unitHasGroupList
     * @return UnitGroup
     */
    public function addUnitHasGroupList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasGroup $unitHasGroupList)
    {
        $this->unitHasGroupList[] = $unitHasGroupList;
    
        return $this;
    }

    /**
     * Remove unitHasGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasGroup $unitHasGroupList
     */
    public function removeUnitHasGroupList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasGroup $unitHasGroupList)
    {
        $this->unitHasGroupList->removeElement($unitHasGroupList);
    }

    /**
     * Get unitHasGroupList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUnitHasGroupList()
    {
        return $this->unitHasGroupList;
    }
}