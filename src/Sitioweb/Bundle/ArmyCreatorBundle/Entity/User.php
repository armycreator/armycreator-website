<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\User
 *
 * @ORM\Table(name="Users")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * id
     * 
     * @var integer
     * @access protected
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * forumId
     * 
     * @var mixed
     * @access protected
     *
     * @ORM\Column(type="integer")
     */
    protected $forumId;

    /**
     * armyList
     * 
     * @var array<Army>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="Army", mappedBy="user")
     */
    private $armyList;

    /**
     * armyGroupList
     * 
     * @var array<Army>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="ArmyGroup", mappedBy="user")
     */
    private $armyGroupList;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->armyList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->armyGroupList = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Gets the value of forumId
     *
     * @return int
     */
    public function getForumId()
    {
        return $this->forumId;
    }
    
    /**
     * Sets the value of forumId
     *
     * @param int $forumId
     * @return self
     */
    public function setForumId($forumId)
    {
        $this->forumId = $forumId;
        return $this;
    }

    /**
     * Add armyList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army $armyList
     * @return ArmyGroup
     */
    public function addArmyList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army $armyList)
    {
        $this->armyList[] = $armyList;
    
        return $this;
    }

    /**
     * Remove armyList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army $armyList
     */
    public function removeArmyList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army $armyList)
    {
        $this->armyList->removeElement($armyList);
    }

    /**
     * Get armyList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getArmyList()
    {
        return $this->armyList;
    }

    /**
     * Add armyGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\ArmyGroup $armyGroupList
     * @return ArmyGroup
     */
    public function addArmyGroupList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\ArmyGroup $armyGroupList)
    {
        $this->armyGroupList[] = $armyGroupList;
    
        return $this;
    }

    /**
     * Remove armyGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\ArmyGroup $armyGroupList
     */
    public function removeArmyGroupList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\ArmyGroup $armyGroupList)
    {
        $this->armyGroupList->removeElement($armyGroupList);
    }

    /**
     * Get armyGroupList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getArmyGroupList()
    {
        return $this->armyGroupList;
    }
}
