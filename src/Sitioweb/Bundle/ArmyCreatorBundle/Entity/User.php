<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\User
 *
 * @ORM\Table(name="Users", indexes={@ORM\Index(name="forum_id_idx", columns={"forumId"})})
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
     * preferences
     *
     * @var UserPreference
     * @access private
     *
	 * @ORM\OneToOne(targetEntity="UserPreference", mappedBy="user")
     */
    private $preferences;

    /**
     * @ORM\ManyToMany(targetEntity="Breed", inversedBy="userList")
     * @ORM\JoinTable(name="CollectionBreed")
     **/
    private $collectionList;

	/**
	 * userHasUnitList
	 *
	 * @var array<UserHasUnit>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="UserHasUnit", mappedBy="user")
	 */
	private $userHasUnitList;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->armyList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->armyGroupList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->collectionList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set preferences
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserPreference $preferences
     * @return User
     */
    public function setPreferences(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserPreference $preferences = null)
    {
        $this->preferences = $preferences;

        return $this;
    }

    /**
     * Get preferences
     *
     * @return \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserPreference
     */
    public function getPreferences()
    {
        return $this->preferences;
    }

    /**
     * Add collectionList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breed
     * @return User
     */
    public function addCollectionList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breed)
    {
        $breed->addUserList($this);
        $this->collectionList[] = $breed;

        return $this;
    }

    /**
     * Remove collectionList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breed
     */
    public function removeCollectionList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breed)
    {
        $breed->removeUserList($this);
        $this->collectionList->removeElement($breed);
    }

    /**
     * Get collectionList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollectionList()
    {
        return $this->collectionList;
    }

    /**
     * Add userHasUnitList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserHasUnit $userHasUnitList
     * @return User
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
     * getUserHasUnitNumber
     *
     * @param Unit $unit
     * @access public
     * @return int
     */
    public function getUnitNumber(Unit $unit)
    {
        if (!$this->getCollectionList()->contains($unit->getBreed())) {
            return null;
        }

        $userHasUnitList = $this->getUserHasUnitList();

        foreach ($userHasUnitList as $userHasUnit) {
            if ($unit->getId() == $userHasUnit->getUnit()->getId()) {
                return $userHasUnit->getNumber();
            }
        }

        return 0;
    }

    /**
     * addEmptyUserHasUnitLine
     *
     * @param Breed $breed
     * @access public
     * @return void
     */
    public function getBreedUserHasUnitList(Breed $breed)
    {
        $unitList = $breed->getUnitList();
        $userHasUnitList = $this->getUserHasUnitList();

        $list = [];
        foreach ($unitList as $unit) {
            $found = false;
            foreach ($userHasUnitList as $userHasUnit) {
                if ($userHasUnit->getUnit()->getId() == $unit->getId()) {
                    $list[] = $userHasUnit;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $uhu = new UserHasUnit();
                $uhu->setNumber(0)
                    ->setUnit($unit)
                    ->setUser($this);

                $list[] = $uhu;
            }
        }

        usort(
            $list,
            function ($a, $b) {
                $aut = $a->getUnit()->getUnitType();
                $but = $b->getUnit()->getUnitType();
                if ($aut == $but) {
                    $collator = new \Collator('fr');
                    return $collator->compare($a->getUnit()->getName(), $b->getUnit()->getName());
                }

                return $aut->getPosition() - $but->getPosition();
            }
        );

        return $list;
    }
}
