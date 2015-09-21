<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLineStuff
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
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
     * @var boolean $asManyAsUnit
     *
     * @ORM\Column(name="asManyAsUnit", type="boolean")
     */
    private $asManyAsUnit;

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


    public function __construct()
    {
        $this->number = 0;
    }

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
     * Set asManyAsUnit
     *
     * @param boolean $asManyAsUnit
     * @return UnitStuff
     */
    public function setAsManyAsUnit($asManyAsUnit)
    {
        $this->asManyAsUnit = $asManyAsUnit;

        return $this;
    }

    /**
     * Get asManyAsUnit
     *
     * @return boolean
     */
    public function getAsManyAsUnit()
    {
        return $this->asManyAsUnit;
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
        $squadLine->addSquadLineStuffList($this);
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

    /**
     * preUpdate
     *
     * @access public
     * @return void
     * @ORM\PrePersist
     */
    public function preUpdate()
    {
        if ($this->getAsManyAsUnit()) {
            $this->setNumber($this->getSquadLine()->getNumber());
        }
    }

    /**
     * mapUnitStuff
     *
     * @param UnitStuff $unitStuff
     * @access public
     * @return $this
     */
    public function mapUnitStuff(UnitStuff $unitStuff, $isEdition = false) {
        $this->setUnitStuff($unitStuff);

        $this->setAsManyAsUnit(!$isEdition && $unitStuff->getAuto());

        if ($this->getAsManyAsUnit()) {
            $this->setNumber($this->getSquadLine()->getNumber());
        }
        return $this;
    }

    /**
     * compare
     *
     * @param SquadLineStuff $a
     * @param SquadLineStuff $b
     * @static
     * @access public
     * @return int
     */
    public static function compare($a, $b)
    {
        $nDiff = $b->getNumber() - $a->getNumber();
        if ($nDiff != 0) {
            return $nDiff;
        }

        $aStuff = $a->getUnitStuff()->getStuff();
        $bStuff = $b->getUnitStuff()->getStuff();
        if ($aStuff instanceof Weapon && $bStuff instanceof Equipement) {
            return -1;
        } elseif ($bStuff instanceof Weapon && $aStuff instanceof Equipement) {
            return 1;
        }

        $collator = new \Collator('fr');
        return $collator->compare($aStuff->getName(), $bStuff->getName());
    }
}
