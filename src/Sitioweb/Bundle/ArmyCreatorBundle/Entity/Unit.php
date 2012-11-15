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
     * @ORM\OneToMany(targetEntity="Unit", mappedBy="parent")
     */
    private $childrenList;

    /**
     * @ORM\ManyToOne(targetEntity="Unit", inversedBy="childrenList")
     */
    private $parent;

	/**
	 * unitHasUnitGroupList
	 *
	 * @var array<UnitHasUnitGroup>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="UnitHasUnitGroup", mappedBy="unit")
	 */
	private $unitHasUnitGroupList;

    /**
     * squadLineList
     * 
     * @var array<SquadLine>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="SquadLine", mappedBy="unit")
     */
    private $squadLineList;



    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->unitHasUnitGroupList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->childrenList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->squadLineList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add unitHasUnitGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup $unitHasUnitGroupList
     * @return Unit
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
     * Add childrenList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $childrenList
     * @return Unit
     */
    public function addChildrenList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $childrenList)
    {
        $this->childrenList[] = $childrenList;
    
        return $this;
    }

    /**
     * Remove childrenList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $childrenList
     */
    public function removeChildrenList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $childrenList)
    {
        $this->childrenList->removeElement($childrenList);
    }

    /**
     * Get childrenList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildrenList()
    {
        return $this->childrenList;
    }

    /**
     * Set parent
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $parent
     * @return Unit
     */
    public function setParent(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add squadLineList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine $squadLineList
     * @return Unit
     */
    public function addSquadLineList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine $squadLineList)
    {
        $this->squadLineList[] = $squadLineList;
    
        return $this;
    }

    /**
     * Remove squadLineList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine $squadLineList
     */
    public function removeSquadLineList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine $squadLineList)
    {
        $this->squadLineList->removeElement($squadLineList);
    }

    /**
     * Get squadLineList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSquadLineList()
    {
        return $this->squadLineList;
    }
}
