<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLineStuff
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SquadLineStuff
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
     * unitStuff
     * 
     * @var UnitStuff
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="UnitStuff", inversedBy="squadLineStuffList")
     */
    private $unitStuff;

    /**
     * squadLine
     * 
     * @var SquadLine
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="SquadLine", inversedBy="squadLineStuffList")
     */
    private $squadLine;

    /**
     * setId
     *
     * @param int $id
     * @access public
     * @return $this
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
     * Set number
     *
     * @param integer $number
     * @return SquadLineStuff
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
     * Set unitStuff
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff $unitStuff
     * @return SquadLineStuff
     */
    public function setUnitStuff(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff $unitStuff = null)
    {
        $this->unitStuff = $unitStuff;
    
        return $this;
    }

    /**
     * Get unitStuff
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff 
     */
    public function getUnitStuff()
    {
        return $this->unitStuff;
    }

    /**
     * Set squadLine
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine $squadLine
     * @return SquadLineStuff
     */
    public function setSquadLine(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine $squadLine = null)
    {
        $this->squadLine = $squadLine;
    
        return $this;
    }

    /**
     * Get squadLine
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine 
     */
    public function getSquadLine()
    {
        return $this->squadLine;
    }
}
