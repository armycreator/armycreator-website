<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Unit extends AbstractUnit
{
    /**
     * @var boolean $canModifyNumber
     *
     * @ORM\Column(name="canModifyNumber", type="boolean")
     */
    private $canModifyNumber;

    /**
     * @var boolean $viewInList
     *
     * @ORM\Column(name="viewInList", type="boolean")
     */
    private $viewInList;

	/**
	 * unitHasGroupList
	 * 
	 * @var array<UnitHasGroup>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="UnitHasUnitGroup", mappedBy="unit")
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
     * Set canModifyNumber
     *
     * @param boolean $canModifyNumber
     * @return Unit
     */
    public function setCanModifyNumber($canModifyNumber)
    {
        $this->canModifyNumber = $canModifyNumber;
    
        return $this;
    }

    /**
     * Get canModifyNumber
     *
     * @return boolean 
     */
    public function getCanModifyNumber()
    {
        return $this->canModifyNumber;
    }

    /**
     * Set viewInList
     *
     * @param boolean $viewInList
     * @return Unit
     */
    public function setViewInList($viewInList)
    {
        $this->viewInList = $viewInList;
    
        return $this;
    }

    /**
     * Get viewInList
     *
     * @return boolean 
     */
    public function getViewInList()
    {
        return $this->viewInList;
    }

    /**
     * Add unitHasGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasGroup $unitHasGroupList
     * @return Unit
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
