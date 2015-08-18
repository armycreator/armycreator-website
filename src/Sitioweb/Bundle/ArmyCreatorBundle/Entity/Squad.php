<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Squad
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var integer $position
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

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
     * army
     *
     * @var Army
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="Army", inversedBy="squadList")
     */
    private $army;

    /**
     * unitType
     *
     * @var UnitType
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="UnitType", inversedBy="squadList")
     */
    private $unitType;

    /**
     * unitGroup
     *
     * @var UnitGroup
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="UnitGroup", inversedBy="squadList")
     */
    private $unitGroup;

    /**
     * squadLineList
     *
     * @var array<SquadLine>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="SquadLine", mappedBy="squad", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
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
        $this->squadLineList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Squad
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
     * Set position
     *
     * @param integer $position
     * @return Squad
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
     * Set army
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army $army
     * @return Squad
     */
    public function setArmy(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army $army = null)
    {
        $this->army = $army;

        return $this;
    }

    /**
     * Get army
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army
     */
    public function getArmy()
    {
        return $this->army;
    }

    /**
     * Set unitType
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType $unitType
     * @return Squad
     */
    public function setUnitType(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType $unitType = null)
    {
        $this->unitType = $unitType;

        return $this;
    }

    /**
     * Get unitType
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType
     */
    public function getUnitType()
    {
        return $this->unitType;
    }

    /**
     * Add squadLineList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine $squadLineList
     * @return Squad
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

    /**
     * Set unitGroup
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup $unitGroup
     * @return Squad
     */
    public function setUnitGroup(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup $unitGroup = null)
    {
        $this->unitGroup = $unitGroup;

        return $this;
    }

    /**
     * Get unitGroup
     *
     * @return \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup
     */
    public function getUnitGroup()
    {
        return $this->unitGroup;
    }

    public function getPoints($onlyActive = false)
    {
        $points = 0;
        $squadLineList = $this->getSquadLineList();
        foreach ($squadLineList as $squadLine) {
            if (!$onlyActive || !$squadLine->isInactive()) {
                $points += $squadLine->getPoints();
            }
        }
        return $points;
    }

    /**
     * getActivePoints
     *
     * @access public
     * @return int
     */
    public function getActivePoints()
    {
        return $this->getPoints(true);
    }

    /**
     * hasInactiveSquadLine
     *
     * @access public
     * @return void
     */
    public function hasInactiveSquadLine()
    {
        $squadLineList = $this->getSquadLineList();
        foreach ($squadLineList as $squadLine) {
            if ($squadLine->isInactive()) {
                return true;
            }
        }

        return false;
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
        $squadLineList = $this->getSquadLineList();

        foreach ($squadLineList as $squadLine) {

            if ($squadLine->getNumber() <= 0) {
                $this->removeSquadLineList($squadLine);
            } else {
                $squadLine->preUpdate();
            }
        }

        $this->setUpdateDate(new \DateTime());
    }

    /**
     * mapUnitGroup
     *
     * @param UnitGroup $unitGroup
     * @param boolean $cascade (default:false)
     * @access public
     * @return $this
     */
    public function mapUnitGroup(UnitGroup $unitGroup, $cascade = false)
    {
        $this->setName($unitGroup->getName());
        $this->setUnitType($unitGroup->getUnitType());
        $this->setUnitGroup($unitGroup);

        if ($cascade === true) {
            $unitHasUnitGroupList = $unitGroup->getUnitHasUnitGroupList();
            foreach ($unitHasUnitGroupList as $unitHasUnitGroup) {
                $squadLine = new SquadLine();
                $squadLine->mapUnitHasUnitGroup($unitHasUnitGroup, $cascade);
                $squadLine->setSquad($this);

                $this->addSquadLineList($squadLine);
            }
        }

        return $this;
    }

    /**
     * addEmptySquadLine
     *
     * @access public
     * @return void
     */
    public function addEmptySquadLine($isEdition = false)
    {
        if ($this->getUnitGroup()) {
            $unitHasUnitGroupList = $this->getUnitGroup()->getUnitHasUnitGroupList();
        } else {
            $unitHasUnitGroupList = array();
        }
        $squadLineList = $this->getSquadLineList();

        foreach ($unitHasUnitGroupList as $unitHasUnitGroup) {
            $contains = false;
            foreach ($squadLineList as $squadLine) {
                if ($squadLine->getUnit() === $unitHasUnitGroup->getUnit()) {
                    $contains = true;
                    $squadLine->addEmptySquadLineStuff($isEdition);
                }
            }

            if ($contains === false) {
                $squadLine = new SquadLine();
                $squadLine->mapUnitHasUnitGroup($unitHasUnitGroup, true, $isEdition);
                $squadLine->setSquad($this);

                $this->addSquadLineList($squadLine);
            }
        }

        // add stuff to external units
        foreach ($squadLineList as $squadLine) {
            $contains = false;
            foreach ($unitHasUnitGroupList as $unitHasUnitGroup) {
                if ($squadLine->getUnit() == $unitHasUnitGroup->getUnit()) {
                    $contains = true;
                    break;
                }
            }

            if (!$contains) {
                $squadLine->addEmptySquadLineStuff($isEdition);
            }
        }

        return $this;
    }
}
