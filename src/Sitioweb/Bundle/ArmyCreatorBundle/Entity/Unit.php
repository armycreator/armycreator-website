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
    CONST GROUP_TYPE = 'unit';

    /**
     * @var boolean $canModifyNumber
     *
     * @ORM\Column(name="canModifyNumber", type="boolean")
     */
    private $canModifyNumber;

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
	 * userHasUnitList
	 *
	 * @var array<UserHasUnit>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="UserHasUnit", mappedBy="unit")
	 */
	private $userHasUnitList;

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
        parent::__construct();
        $this->unitHasUnitGroupList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->childrenList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unitStuffList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add userHasUnitList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserHasUnit $userHasUnitList
     * @return Unit
     */
    public function addUserHasUnitList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserHasUnit $userHasUnitList)
    {
        $this->userHasUnitList[] = $userHasUnitList;
    
        return $this;
    }

    /**
     * Remove userHasUnitList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserHasUnit $userHasUnitList
     */
    public function removeUserHasUnitList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserHasUnit $userHasUnitList)
    {
        $this->userHasUnitList->removeElement($userHasUnitList);
    }

    /**
     * Get userHasUnitList
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserHasUnitList()
    {
        return $this->userHasUnitList;
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
