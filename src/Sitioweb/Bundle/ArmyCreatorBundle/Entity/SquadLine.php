<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
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
     * @var Unit
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="Unit", inversedBy="squadLineList")
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
	 * @ORM\OneToMany(targetEntity="SquadLineStuff", mappedBy="squadLine", cascade={"all"}, orphanRemoval=true)
     */
    private $squadLineStuffList;

    /**
     * @var \DateTime $createDate
     *
     * @ORM\Column(name="createDate", type="datetime", nullable=true)
     */
    private $createDate;

    /**
     * @var \DateTime $updateDate
     *
     * @ORM\Column(name="updateDate", type="datetime", nullable=true)
     */
    private $updateDate;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->squadLineStuffList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->position = 0;
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
     * @return SquadLine
     */
    public function setNumber($number)
    {
        $this->number = $number;

        $squadLineStuffList = $this->getSquadLineStuffList();
        $this->preUpdate();

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
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unit
     * @return SquadLine
     */
    public function setUnit(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit
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

    /**
     * getOrderSquadLineStuffList
     *
     * @access public
     * @return array
     */
    public function getOrderSquadLineStuffList()
    {
        $squadLineStuffList = $this->getSquadLineStuffList();
        if (!is_array($squadLineStuffList)) {
            $squadLineStuffList = $squadLineStuffList->toArray();
        }

        usort(
            $squadLineStuffList,
            function ($a, $b) {
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

                return strcmp(
                    $aStuff->getName(),
                    $bStuff->getName()
                );
            }
        );

        return $squadLineStuffList;
    }


    /**
     * getNoDefaultSquadLineStuffList
     *
     * @access public
     * @return array
     */
    public function getNoDefaultSquadLineStuffList()
    {
        $squadLineStuffList = $this->getSquadLineStuffList();
        $list = array();

        foreach ($squadLineStuffList as $squadLineStuff) {
            $unitStuff = $squadLineStuff->getUnitStuff();
            if (!$unitStuff->getAuto() || $unitStuff->getPoints() > 0) {
                $list[] = $squadLineStuff;
            }
        }

        return $list;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Squad
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Squad
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * getPoints
     *
     * @access public
     * @return int
     */
    public function getPoints()
    {
        $points = 0;
        $unit = $this->getUnit();
        if ($unit instanceof Unit) {
            $points = $this->getNumber() * $unit->getPoints();
        }
        $squadLineStuffList = $this->getSquadLineStuffList();
        foreach ($squadLineStuffList as $squadLineStuff) {
            $points += $squadLineStuff->getNumber() * $squadLineStuff->getUnitStuff()->getPoints();
        }


        return $points;
    }

    /**
     * prePersist
     *
     * @access public
     * @return void
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setCreateDate(new \DateTime());
    }

    /**
     * preUpdate
     *
     * @access public
     * @return void
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $squadLineStuffList = $this->getSquadLineStuffList();
        foreach ($squadLineStuffList as $squadLineStuff) {
            if ($squadLineStuff->getNumber() <= 0) {
                $this->removeSquadLineStuffList($squadLineStuff);
            } else {
                $squadLineStuff->preUpdate();
            }
        }

        $this->setUpdateDate(new \DateTime());
    }

    /**
     * mapUnitHasUnitGroup
     *
     * @param UnitHasUnitGroup $unitHasUnitGroup
     * @param boolean $cascade (default:false)
     * @access public
     * @return $this
     */
    public function mapUnitHasUnitGroup(UnitHasUnitGroup $unitHasUnitGroup, $cascade = false, $isEdition = false)
    {
        $this->setNumber($isEdition ? 0 : $unitHasUnitGroup->getUnitNumber());
        if ($unitHasUnitGroup->getMainUnit()) {
            $this->setPosition(1);
        } else {
            $this->setPosition(2);
        }
        $this->setUnit($unitHasUnitGroup->getUnit());

        if ($cascade === true) {
            $unitStuffList = $unitHasUnitGroup->getUnit()->getUnitStuffList();

            foreach ($unitStuffList as $unitStuff) {
                if ($unitStuff->getVisible()) {
                    $squadLineStuff = new SquadLineStuff();
                    $squadLineStuff->setSquadLine($this);
                    $squadLineStuff->mapUnitStuff($unitStuff);

                    $this->addSquadLineStuffList($squadLineStuff);
                }
            }
        }

        return $this;
    }

    /**
     * addEmptySquadLineStuff
     *
     * @access public
     * @return void
     */
    public function addEmptySquadLineStuff($isEdition = false)
    {

        $unit = $this->getUnit();
        $unitStuffList = $unit->getUnitStuffList();
        $squadLineStuffList = $this->getSquadLineStuffList();

        foreach ($unitStuffList as $unitStuff) {
            if ($unitStuff->getVisible()) {
                $contains = false;
                foreach ($squadLineStuffList as $squadLineStuff) {
                    if ($squadLineStuff->getUnitStuff() === $unitStuff) {
                        $contains = true;
                        break;
                    }
                }

                if ($contains === false) {
                    $squadLineStuff = new SquadLineStuff();
                    $squadLineStuff->setSquadLine($this);
                    $squadLineStuff->mapUnitStuff($unitStuff, $isEdition);

                    $this->addSquadLineStuffList($squadLineStuff);
                }
            }
        }

        return $this;
    }

}
