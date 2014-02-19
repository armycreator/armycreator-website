<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPreference
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserPreference
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showDefaultStuff", type="boolean")
     */
    private $showDefaultStuff;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showStuffDescription", type="boolean")
     */
    private $showStuffDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showUnitPoints", type="boolean")
     */
    private $showUnitPoints;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showStuffPoints", type="boolean")
     */
    private $showStuffPoints;

    /**
     * @var string
     *
     * @ORM\Column(name="separator_", type="string", length=10)
     */
    private $separator;

    /**
     * @var string
     *
     * @ORM\Column(name="colorSquadType", type="string", length=20)
     */
    private $colorSquadType;

    /**
     * @var string
     *
     * @ORM\Column(name="colorSquad", type="string", length=20)
     */
    private $colorSquad;

    /**
     * @var string
     *
     * @ORM\Column(name="colorSquadDetail", type="string", length=20)
     */
    private $colorSquadDetail;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showNbIfAlone", type="boolean")
     */
    private $showNbIfAlone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showUnitCarac", type="boolean")
     */
    private $showUnitCarac;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showPersonnalName", type="boolean")
     */
    private $showPersonnalName;

    /**
     * user
     *
     * @var User
     * @access private
     *
	 * @ORM\OneToOne(targetEntity="User", inversedBy="preferences")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * preferedBreed
     *
     * @var Breed
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Breed", inversedBy="userPreferenceList")
     */
    private $breed;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->showDefaultStuff = true;
        $this->showStuffDescription = false;
        $this->showUnitPoints = true;
        $this->showStuffPoints = true;
        $this->separator = ', ';
        $this->colorSquadType = '#0000ff';
        $this->colorSquad = '#ff0000';
        $this->colorSquadDetail = '#00a650';
        $this->showNbIfAlone = true;
        $this->showUnitCarac = true;
        $this->showPersonnalName = true;
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
     * Set showDefaultStuff
     *
     * @param boolean $showDefaultStuff
     * @return UserPreference
     */
    public function setShowDefaultStuff($showDefaultStuff)
    {
        $this->showDefaultStuff = $showDefaultStuff;

        return $this;
    }

    /**
     * Get showDefaultStuff
     *
     * @return boolean
     */
    public function getShowDefaultStuff()
    {
        return $this->showDefaultStuff;
    }

    /**
     * Set showStuffDescription
     *
     * @param boolean $showStuffDescription
     * @return UserPreference
     */
    public function setShowStuffDescription($showStuffDescription)
    {
        $this->showStuffDescription = $showStuffDescription;

        return $this;
    }

    /**
     * Get showStuffDescription
     *
     * @return boolean
     */
    public function getShowStuffDescription()
    {
        return $this->showStuffDescription;
    }

    /**
     * Set showUnitPoints
     *
     * @param boolean $showUnitPoints
     * @return UserPreference
     */
    public function setShowUnitPoints($showUnitPoints)
    {
        $this->showUnitPoints = $showUnitPoints;

        return $this;
    }

    /**
     * Get showUnitPoints
     *
     * @return boolean
     */
    public function getShowUnitPoints()
    {
        return $this->showUnitPoints;
    }

    /**
     * Set showStuffPoints
     *
     * @param boolean $showStuffPoints
     * @return UserPreference
     */
    public function setShowStuffPoints($showStuffPoints)
    {
        $this->showStuffPoints = $showStuffPoints;

        return $this;
    }

    /**
     * Get showStuffPoints
     *
     * @return boolean
     */
    public function getShowStuffPoints()
    {
        return $this->showStuffPoints;
    }

    /**
     * Set separator
     *
     * @param string $separator
     * @return UserPreference
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Get separator
     *
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * Set colorSquadType
     *
     * @param string $colorSquadType
     * @return UserPreference
     */
    public function setColorSquadType($colorSquadType)
    {
        $this->colorSquadType = $this->getColor($colorSquadType);

        return $this;
    }

    /**
     * Get colorSquadType
     *
     * @return string
     */
    public function getColorSquadType()
    {
        return $this->colorSquadType;
    }

    /**
     * Set colorSquad
     *
     * @param string $colorSquad
     * @return UserPreference
     */
    public function setColorSquad($colorSquad)
    {
        $this->colorSquad = $this->getColor($colorSquad);

        return $this;
    }

    /**
     * Get colorSquad
     *
     * @return string
     */
    public function getColorSquad()
    {
        return $this->colorSquad;
    }

    /**
     * Set colorSquadDetail
     *
     * @param string $colorSquadDetail
     * @return UserPreference
     */
    public function setColorSquadDetail($colorSquadDetail)
    {
        $this->colorSquadDetail = $this->getColor($colorSquadDetail);

        return $this;
    }

    /**
     * Get colorSquadDetail
     *
     * @return string
     */
    public function getColorSquadDetail()
    {
        return $this->colorSquadDetail;
    }

    /**
     * Set showNbIfAlone
     *
     * @param boolean $showNbIfAlone
     * @return UserPreference
     */
    public function setShowNbIfAlone($showNbIfAlone)
    {
        $this->showNbIfAlone = $showNbIfAlone;

        return $this;
    }

    /**
     * Get showNbIfAlone
     *
     * @return boolean
     */
    public function getShowNbIfAlone()
    {
        return $this->showNbIfAlone;
    }

    /**
     * Set showUnitCarac
     *
     * @param boolean $showUnitCarac
     * @return UserPreference
     */
    public function setShowUnitCarac($showUnitCarac)
    {
        $this->showUnitCarac = $showUnitCarac;

        return $this;
    }

    /**
     * Get showUnitCarac
     *
     * @return boolean
     */
    public function getShowUnitCarac()
    {
        return $this->showUnitCarac;
    }

    /**
     * Set showPersonnalName
     *
     * @param boolean $showPersonnalName
     * @return UserPreference
     */
    public function setShowPersonnalName($showPersonnalName)
    {
        $this->showPersonnalName = $showPersonnalName;

        return $this;
    }

    /**
     * Get showPersonnalName
     *
     * @return boolean
     */
    public function getShowPersonnalName()
    {
        return $this->showPersonnalName;
    }

    /**
     * Set user
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\User $user
     * @return UserPreference
     */
    public function setUser(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Sitioweb\Bundle\ArmyCreatorBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set breed
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breed
     * @return UserPreference
     */
    public function setBreed(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breed = null)
    {
        $this->breed = $breed;

        return $this;
    }

    /**
     * Get breed
     *
     * @return \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed
     */
    public function getBreed()
    {
        return $this->breed;
    }

    /**
     * getColor
     *
     * @access private
     * @return void
     */
    private function getColor($color)
    {
        if (strlen($color) === 6 && substr($color, 0, 1) != '#' && preg_match('/[0-9A-Fa-f]{6}/', $color)) {
            return '#' . $color;
        }
        return $color;
    }
}
