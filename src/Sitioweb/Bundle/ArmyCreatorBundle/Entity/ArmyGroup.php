<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\ArmyGroup
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ArmyGroup
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
     * user
     * 
     * @var User
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="armyGroupList")
     */
    private $user;

    /**
     * armyList
     * 
     * @var array<Army>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="Army", mappedBy="armyGroup")
     */
    private $armyList;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->armyList = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * setId
     *
     * @param int $id
     * @access public
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return ArmyGroup
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
     * Set user
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\User $user
     * @return Army
     */
    public function setUser(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
