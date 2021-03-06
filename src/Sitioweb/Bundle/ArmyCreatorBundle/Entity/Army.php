<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Sitioweb\Bundle\ArmyCreatorBundle\Entity\Repository\ArmyRepository")
 */
class Army
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
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=10)
     */
    private $status;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * slug
     *
     * @var string
     * @access private
     *
     * @Gedmo\Slug(fields={"name"}, unique=true, updatable=false)
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * slug
     *
     * @var string
     * @access private
     *
     * @Gedmo\Slug(fields={"name"}, unique=false, updatable=true)
     * @ORM\Column(length=255, unique=false)
     */
    private $currentSlug;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer $wantedPoints
     *
     * @ORM\Column(name="wantedPoints", type="integer")
     */
    private $wantedPoints;

    /**
     * @var integer $points
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @var integer $points
     *
     * @ORM\Column(name="active_points", type="integer")
     */
    private $activePoints;

    /**
     * @var boolean $isShared
     *
     * @ORM\Column(name="isShared", type="boolean")
     */
    private $isShared;

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
     * squadList
     *
     * @var array<Squad>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="Squad", mappedBy="army", cascade={"remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $squadList;

    /**
     * squadListByType
     *
     * @var array
     * @access private
     */
    private $squadListByType = null;

    /**
     * breed
     *
     * @var Breed
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="Breed", inversedBy="armyList")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $breed;

    /**
     * armyGroup
     *
     * @var ArmyGroup
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="ArmyGroup", inversedBy="armyList")
     */
    private $armyGroup;

    /**
     * user
     *
     * @var User
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="armyList")
     */
    private $user;

    /**
     * wantedUnitList
     *
     * @var array
     * @access private
     */
    private $wantedUnitList;


    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->squadList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setPoints(0);
        $this->setActivePoints(0);
        $this->setWantedPoints(0);
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
     * Set status
     *
     * @param string $status
     * @return Army
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Army
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
     * setSlug
     *
     * @param string $slug
     * @access public
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * getSlug
     *
     * @access public
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Gets the value of currentSlug
     *
     * @return string
     */
    public function getCurrentSlug()
    {
        return $this->currentSlug ?: 'army';
    }

    /**
     * Sets the value of currentSlug
     *
     * @param string $currentSlug currentSlug
     *
     * @return Army
     */
    public function setCurrentSlug($currentSlug)
    {
        $this->currentSlug = $currentSlug;
        return $this;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Army
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set wantedPoints
     *
     * @param integer $wantedPoints
     * @return Army
     */
    public function setWantedPoints(int $wantedPoints)
    {
        $this->wantedPoints = $wantedPoints;

        return $this;
    }

    /**
     * Get wantedPoints
     *
     * @return integer
     */
    public function getWantedPoints()
    {
        return $this->wantedPoints;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return Army
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
     * Getter for activePoints
     *
     * return int
     */
    public function getActivePoints()
    {
        return $this->activePoints;
    }

    /**
     * Setter for activePoints
     *
     * @param int $activePoints
     * @return Army
     */
    public function setActivePoints($activePoints)
    {
        $this->activePoints = $activePoints;

        return $this;
    }

    /**
     * Set isShared
     *
     * @param boolean $isShared
     * @return Army
     */
    public function setIsShared($isShared)
    {
        $this->isShared = $isShared;

        return $this;
    }

    /**
     * Get isShared
     *
     * @return boolean
     */
    public function getIsShared()
    {
        return $this->isShared;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Army
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
     * @return Army
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
     * Add squadList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squadList
     * @return Army
     */
    public function addSquadList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squadList)
    {
        $this->squadList[] = $squadList;

        return $this;
    }

    /**
     * Remove squadList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squadList
     */
    public function removeSquadList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squadList)
    {
        $this->squadList->removeElement($squadList);
    }

    /**
     * Get squadList
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSquadList()
    {
        return $this->squadList;
    }

    /**
     * getSquadListByType
     *
     * @access public
     * @return array
     */
    public function getSquadListByType()
    {
        if (null === $this->squadListByType) {
            $squadList = $this->getSquadList();

            $unitTypeList = $this->getBreed()->getUnitTypeList()->toArray();
            $externalUnitTypeList = [];

            foreach ($squadList as $squad) {
                $tmpUnitType = $squad->getUnitType();

                // add external breed unit types
                if (!in_array($tmpUnitType, $unitTypeList) && !in_array($tmpUnitType, $externalUnitTypeList)) {
                    $externalUnitTypeList[] = $tmpUnitType;
                }
            }

            usort(
                $externalUnitTypeList,
                ['Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType', 'compare']
            );

            $unitTypeList = array_merge($unitTypeList, $externalUnitTypeList);

            foreach ($unitTypeList as $unitType) {
                $tmpArray = array();
                $points = 0;
                $activePoints = 0;

                foreach ($squadList as $squad) {
                    if ($squad->getUnitType() == $unitType) {
                        $tmpArray[] = $squad;
                        $points += $squad->getPoints();
                        $activePoints += $squad->getActivePoints();
                    }
                }

                $this->squadListByType[] = array(
                    'unitType' => $unitType,
                    'squadList' => $tmpArray,
                    'points' => $points,
                    'activePoints' => $activePoints,
                    'hasInactiveSquad' => $points != $activePoints
                );
            }
        }

        return $this->squadListByType;
    }

    /**
     * hasInactiveSquad
     *
     * @access public
     * @return void
     */
    public function hasInactiveSquad()
    {
        return $this->getPoints() != $this->getActivePoints();
    }

    /**
     * Set breed
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breed
     * @return Army
     */
    public function setBreed(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breed = null)
    {
        $this->breed = $breed;

        return $this;
    }

    /**
     * Get breed
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed
     */
    public function getBreed()
    {
        return $this->breed;
    }

    /**
     * Set armyGroup
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\ArmyGroup $armyGroup
     * @return Army
     */
    public function setArmyGroup(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\ArmyGroup $armyGroup = null)
    {
        $this->armyGroup = $armyGroup;

        return $this;
    }

    /**
     * Get armyGroup
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\ArmyGroup
     */
    public function getArmyGroup()
    {
        return $this->armyGroup;
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

    /**
     * prePersist
     *
     * @access public
     * @return void
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if ($this->getPoints() === null) {
            $this->setPoints(0);
        }

        if ($this->getWantedPoints() === null) {
            $this->setWantedPoints(0);
        }

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
        $this->setUpdateDate(new \DateTime());
        $name = $this->getName();
        if (empty($name)) {
            $this->setName('[no name]');
        }
    }

    /**
     * generatePoints
     *
     * @access public
     * @return void
     */
    public function generatePoints()
    {
        $squadList = $this->getSquadList();

        $points = 0;
        $activePoints = 0;
        foreach ($squadList as $squad) {
            $points += $squad->getPoints();
            $activePoints += $squad->getActivePoints();
        }
        $this->setPoints($points);
        $this->setActivePoints($activePoints);

        return $points;
    }

    public function getUnitNumber(Unit $unit)
    {
        if (!isset($this->wantedUnitList)) {
            $squadList = $this->getSquadList();
            foreach ($squadList as $squad) {
                $squadLineList = $squad->getSquadLineList();
                foreach ($squadLineList as $squadLine) {
                    $key = $squadLine->getUnit()->getId();
                    if (!isset($this->wantedUnitList[$key])) {
                        $this->wantedUnitList[$key] = 0;
                    }
                    $this->wantedUnitList[$key] += $squadLine->getNumber();
                }
            }
        }

        return $this->wantedUnitList[$unit->getId()];
    }

    /**
     * __toString
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->getId() . '|' . $this->getName();
    }
}
