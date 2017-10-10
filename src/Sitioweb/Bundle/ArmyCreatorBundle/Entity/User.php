<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\User
 *
 * @ORM\Table(name="Users", indexes={@ORM\Index(name="forum_id_idx", columns={"forumId"})})
 * @ORM\Entity
 */
class User
{
    const ROLE_DEFAULT = 'ROLE_USER';

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
     * @var string
     *
     * @ORM\Column(name="username", length=180, nullable=false, unique=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", length=180, nullable=false, unique=true)
     */
    protected $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    protected $roles;

    /**
     * slug
     *
     * @var string
     * @access protected
     *
     * @ORM\Column(name="slug", length=255, nullable=false)
     * @Gedmo\Slug(fields={"username"})
     */
    protected $slug;

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
     * wantToPlay
     *
     * @var mixed
     * @access private
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $wantToPlay;

    /**
     * informations
     *
     * @var array
     * @access private
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $informations;

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
	 * userHasUnitList
	 *
	 * @var array<UserUnitFeature>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="UserUnitFeature", mappedBy="user")
	 */
	private $userUnitFeatureList;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->roles = [];
        $this->armyList = new ArrayCollection();
        $this->armyGroupList = new ArrayCollection();
        $this->collectionList = new ArrayCollection();
        $this->userHasUnitList = new ArrayCollection();
        $this->userUnitFeatureList = new ArrayCollection();
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
     * Gets the value of slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets the value of slug
     *
     * @param string $slug slug
     *
     * @return User
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
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
     * Add userUnitFeatureList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserUnitFeature $userUnitFeatureList
     * @return User
     */
    public function addUserUnitFeatureList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserUnitFeature $userUnitFeatureList)
    {
        $this->userUnitFeatureList[] = $userUnitFeatureList;

        return $this;
    }

    /**
     * Remove userUnitFeatureList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserUnitFeature $userUnitFeatureList
     */
    public function removeUserUnitFeatureList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserUnitFeature $userUnitFeatureList)
    {
        $this->userUnitFeatureList->removeElement($userUnitFeatureList);
    }

    /**
     * Get userUnitFeatureList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserUnitFeatureList()
    {
        return $this->userUnitFeatureList;
    }

    /**
     * Gets the value of informations
     *
     * @return array
     */
    public function getInformations()
    {
        return $this->informations;
    }

    /**
     * Gets the value of wantToPlay
     *
     * @return boolean
     */
    public function getWantToPlay()
    {
        return $this->wantToPlay;
    }

    /**
     * Sets the value of wantToPlay
     *
     * @param boolean $wantToPlay
     *
     * @return User
     */
    public function setWantToPlay($wantToPlay)
    {
        $this->wantToPlay = $wantToPlay;
        return $this;
    }

    /**
     * Sets the value of informations
     *
     * @param array $informations user informations
     *
     * @return User
     */
    public function setInformations($informations)
    {
        $this->informations = $informations;
        return $this;
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

    public function getPreferedBreedList()
    {
        if (!isset($this->preferedBreedList)) {
            $armyList = $this->getArmyList();

            $breedScore = [];
            $breedList = [];
            $i = 1;
            foreach ($armyList as $army) {
                $breed = $army->getBreed();
                if ($breed) {
                    $breedId = $breed->getId();
                    if (isset($breedScore[$breedId])) {
                        $breedScore[$breedId] += $i;
                    } else {
                        $breedScore[$breedId] = $i;
                    }
                    $breedList[$breedId] = $breed;
                    $i ++;
                }
            }

            arsort($breedScore);

            $this->preferedBreedList = [];
            $breedScoreKeyList = array_keys($breedScore);
            foreach ($breedScoreKeyList as $breedScoreKey) {
                $this->preferedBreedList[] = $breedList[$breedScoreKey];
            }
        }

        return $this->preferedBreedList;
    }

    /**
     * {@inheritdoc}
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Gets the last login time.
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        $roles = $this->roles;

        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;

        return array_unique($roles);
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function isSuperAdmin()
    {
        return $this->hasRole(static::ROLE_SUPER_ADMIN);
    }

    /**
     * {@inheritdoc}
     */
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSuperAdmin($boolean)
    {
        if (true === $boolean) {
            $this->addRole(static::ROLE_SUPER_ADMIN);
        } else {
            $this->removeRole(static::ROLE_SUPER_ADMIN);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastLogin(\DateTime $time = null)
    {
        $this->lastLogin = $time;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRoles(array $roles)
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getUsername();
    }
}
