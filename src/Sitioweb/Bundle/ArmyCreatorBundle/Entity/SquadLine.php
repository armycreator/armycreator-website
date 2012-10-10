<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SquadLine
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
     * @var integer $number
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var integer $position
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * unit
     * 
     * @var AbstractUnit
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="AbstractUnit", inversedBy="squadLineList")
     */
    private $unit;

    /**
     * squad
     * 
     * @var Squad
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="Squad", inversedBy="squadLineList")
     */
    private $squad;

    /**
     * squadLineStuffList
     * 
     * @var array<SquadLineStuff>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="SquadLineStuff", mappedBy="squadLine")
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
     * Set number
     *
     * @param integer $number
     * @return SquadLine
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return SquadLine
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set unit
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\AbstractUnit $unit
     * @return SquadLine
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
     * Set squad
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squad
     * @return SquadLine
     */
    public function setSquad(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squad = null)
    {
        $this->squad = $squad;
    
        return $this;
    }

    /**
     * Get squad
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad 
     */
    public function getSquad()
    {
        return $this->squad;
    }

    /**
     * Add squadLineStuffList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLineStuff $squadLineStuffList
     * @return SquadLine
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
}