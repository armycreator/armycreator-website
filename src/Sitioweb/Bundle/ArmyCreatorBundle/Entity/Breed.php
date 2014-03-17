<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Oneup\AclBundle\Mapping\Annotation as Acl;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed
 *
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="available", columns={"available"})
 *     }
 * )
 * @Acl\DomainObject({
 *     @Acl\ClassPermission({ "ROLE_ADMIN": MaskBuilder::MASK_OPERATOR }),
 *     @Acl\ClassPermission({ "ROLE_CONTRIB_ALL": MaskBuilder::MASK_EDIT }),
 *     @Acl\ClassPermission({ "ROLE_CONTRIB": MaskBuilder::MASK_VIEW })
 * })
 */
class Breed
{
    /**
     * @var integer $id
     * @access private
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string $name
     * @access private
     *
     * @ORM\Column(type="string", length=255, unique=true)
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
     * newVersion
     *
     * @var mixed
     * @access private
     *
     * @ORM\OneToOne(targetEntity="Breed")
     */
    private $newVersion;

    /**
     * available
     *
     * @var mixed
     * @access private
     *
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Choice(choices = {0,1})
     */
    private $available;

    /**
     * image
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     * @access private
     */
    private $image;

    /**
     * game
     *
     * @var mixed
     * @access private
     *
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="breedList")
     */
    private $game;

    /**
     * breedGroup
     *
     * @var mixed
     * @access private
     *
     * @ORM\ManyToOne(targetEntity="BreedGroup", inversedBy="breedList")
     */
    private $breedGroup;

    /**
     * unitGroupList
     *
     * @var array
     * @access private
     *
     * @ORM\OneToMany(targetEntity="UnitGroup", mappedBy="breed")
     */
    private $unitGroupList;

    /**
     * unitTypeList
     *
     * @var array
     * @access private
     *
     * @ORM\OneToMany(targetEntity="UnitType", mappedBy="breed")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $unitTypeList;

    /**
     * userPreferenceList
     *
     * @var array
     * @access private
     *
     * @ORM\OneToMany(targetEntity="UserPreference", mappedBy="breed")
     */
    private $userPreferenceList;

    /**
     * stuffList
     *
     * @var array
     * @access private
     *
     * @ORM\OneToMany(targetEntity="Stuff", mappedBy="breed")
     */
    private $stuffList;

    /**
     * armyList
     *
     * @var array<Army>
     * @access private
     *
     * @ORM\OneToMany(targetEntity="Army", mappedBy="breed")
     */
    private $armyList;

    /**
     * userList
     * @ORM\ManyToMany(targetEntity="User", mappedBy="collectionList")
     *
     * @var mixed
     * @access private
     */
    private $userList;


    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->unitGroupList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unitTypeList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->stuffList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userPreferenceList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->armyList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Breed
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
     * Set image
     *
     * @param string $image
     * @return Breed
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set game
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game $game
     * @return Breed
     */
    public function setGame(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game $game = null)
    {
        $this->game = $game;
        return $this;
    }

    /**
     * Get game
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set breedGroup
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\BreedGroup $breedGroup
     * @return Breed
     */
    public function setBreedGroup(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\BreedGroup $breedGroup = null)
    {
        $this->breedGroup = $breedGroup;
        return $this;
    }

    /**
     * Get breedGroup
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\BreedGroup
     */
    public function getBreedGroup()
    {
        return $this->breedGroup;
    }

    /**
     * Set newVersion
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $newVersion
     * @return Breed
     */
    public function setNewVersion(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $newVersion = null)
    {
        $this->newVersion = $newVersion;
        return $this;
    }

    /**
     * Get newVersion
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed
     */
    public function getNewVersion()
    {
        return $this->newVersion;
    }

    /**
     * Set available
     *
     * @param int $available
     * @return Breed
     */
    public function setAvailable($available)
    {
        $this->available = $available;
        return $this;
    }

    /**
     * Get available
     *
     * @return int
     */
    public function getAvailable()
    {
        return $this->available;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add unitGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup $unitGroupList
     * @return Breed
     */
    public function addUnitGroupList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup $unitGroupList)
    {
        $this->unitGroupList[] = $unitGroupList;

        return $this;
    }

    /**
     * Remove unitGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup $unitGroupList
     */
    public function removeUnitGroupList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup $unitGroupList)
    {
        $this->unitGroupList->removeElement($unitGroupList);
    }

    /**
     * Get unitGroupList
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getUnitGroupList()
    {
        return $this->unitGroupList;
    }

    /**
     * Add unitTypeList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType $unitTypeList
     * @return Breed
     */
    public function addUnitTypeList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType $unitTypeList)
    {
        $this->unitTypeList[] = $unitTypeList;

        return $this;
    }

    /**
     * Remove unitTypeList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType $unitTypeList
     */
    public function removeUnitTypeList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType $unitTypeList)
    {
        $this->unitTypeList->removeElement($unitTypeList);
    }

    /**
     * Get unitTypeList
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getUnitTypeList()
    {
        return $this->unitTypeList;
    }

    /**
     * Add armyList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army $armyList
     * @return Breed
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
     * Add stuffList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff $stuffList
     * @return Breed
     */
    public function addStuffList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff $stuffList)
    {
        $this->stuffList[] = $stuffList;

        return $this;
    }

    /**
     * Remove stuffList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff $stuffList
     */
    public function removeStuffList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff $stuffList)
    {
        $this->stuffList->removeElement($stuffList);
    }

    /**
     * Get stuffList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStuffList()
    {
        return $this->stuffList;
    }

    /**
     * Add userPreferenceList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserPreference $userPreferenceList
     * @return Breed
     */
    public function addUserPreferenceList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserPreference $userPreferenceList)
    {
        $this->userPreferenceList[] = $userPreferenceList;

        return $this;
    }

    /**
     * Remove userPreferenceList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserPreference $userPreferenceList
     */
    public function removeUserPreferenceList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserPreference $userPreferenceList)
    {
        $this->userPreferenceList->removeElement($userPreferenceList);
    }

    /**
     * Get userPreferenceList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserPreferenceList()
    {
        return $this->userPreferenceList;
    }

    /**
     * Add userList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\User $userList
     * @return Breed
     */
    public function addUserList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\User $user)
    {
        $this->userList[] = $user;

        return $this;
    }

    /**
     * Remove userList
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\User $userList
     */
    public function removeUserList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\User $userList)
    {
        $this->userList->removeElement($userList);
    }

    /**
     * Get userList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserList()
    {
        return $this->userList;
    }

    public function getUnitList()
    {
        $unitGroupList = $this->getUnitGroupList();
        $unitList = [];
        foreach ($unitGroupList as $unitGroup) {
            $unitHasUnitGroupList = $unitGroup->getUnitHasUnitGroupList();
            foreach ($unitHasUnitGroupList as $unitHasUnitGroup) {
                $unit = $unitHasUnitGroup->getUnit();
                $unitList[$unit->getId()] = $unit;
            }
        }

        return $unitList;
    }
}
