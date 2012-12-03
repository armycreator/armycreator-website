<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UnitStuff
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
     * @var integer $points
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @var boolean $auto
     *
     * @ORM\Column(name="auto", type="boolean")
     */
    private $auto;

    /**
     * visible
     * 
     * @var boolean
     * @access private
     *
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * unit
     * 
     * @var Unit
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Unit", inversedBy="unitStuffList")
     */
    private $unit;

    /**
     * stuff
     * 
     * @var Stuff
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Stuff", inversedBy="unitStuffList")
     */
    private $stuff;

    /**
     * squadLineStuffList
     * 
     * @var array<SquadLineStuff>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="SquadLineStuff", mappedBy="unitStuff")
     */
    private $squadLineStuffList;


    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->squadLineStuffList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set points
     *
     * @param integer $points
     * @return UnitStuff
     */
    public function setPoints($points)
    {
        $this->points = $points;
    
        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set auto
     *
     * @param boolean $auto
     * @return UnitStuff
     */
    public function setAuto($auto)
    {
        $this->auto = $auto;
    
        return $this;
    }

    /**
     * Get auto
     *
     * @return boolean 
     */
    public function getAuto()
    {
        return $this->auto;
    }

    /**
     * Set unit
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\AbstractUnit $unit
     * @return UnitStuff
     */
    public function setUnit(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\AbstractUnit $unit = null)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\AbstractUnit 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set stuff
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff $stuff
     * @return UnitStuff
     */
    public function setStuff(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff $stuff = null)
    {
        $this->stuff = $stuff;
    
        return $this;
    }

    /**
     * Get stuff
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff 
     */
    public function getStuff()
    {
        return $this->stuff;
    }

    /**
     * Add squadLineStuffList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLineStuff $squadLineStuffList
     * @return UnitStuff
     */
    public function addSquadLineStuffList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLineStuff $squadLineStuffList)
    {
        $this->squadLineStuffList[] = $squadLineStuffList;
    
        return $this;
    }

    /**
     * Remove squadLineStuffList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLineStuff $squadLineStuffList
     */
    public function removeSquadLineStuffList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLineStuff $squadLineStuffList)
    {
        $this->squadLineStuffList->removeElement($squadLineStuffList);
    }

    /**
     * Get squadLineStuffList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSquadLineStuffList()
    {
        return $this->squadLineStuffList;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return UnitStuff
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    
        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }
}
