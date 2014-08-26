<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Oneup\AclBundle\Mapping\Annotation as Acl;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game
 *
 * @ORM\Entity(repositoryClass="GameRepository")
 * @Acl\DomainObject({
 *     @Acl\ClassPermission({ "ROLE_ADMIN": MaskBuilder::MASK_OPERATOR }),
 *     @Acl\ClassPermission({ "ROLE_CONTRIB_ALL": MaskBuilder::MASK_EDIT }),
 *     @Acl\ClassPermission({ "ROLE_CONTRIB": MaskBuilder::MASK_VIEW })
 * })
 */
class Game
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
     * @var string $code
     * @access private
     *
     * @ORM\Column(type="string", length=32, unique=true)
     */
    private $code;

    /**
     * @var string $name
     * @access private
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * unitFeaturePublic
     *
     * @var mixed
     * @access private
     *
     * @ORM\Column(type="boolean")
     */
    private $unitFeaturePublic;

	/**
	 * breedList
	 *
	 * @var mixed
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="Breed", mappedBy="game")
	 * @ORM\OrderBy({ "name": "ASC" })
	 */
	private $breedList;

    /**
     * availableBreedList
     *
     * @var array
     * @access private
     */
    private $availableBreedList;

	/**
	 * breedGroupList
	 *
	 * @var mixed
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="BreedGroup", mappedBy="game")
	 */
	private $breedGroupList;

    public function __construct()
    {
        $this->breedGroupList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unitFeaturePublic = false;
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
     * Set code
     *
     * @param string $code
     * @return Game
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Game
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
     * Add breedGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\BreedGroup $breedGroupList
     * @return Game
     */
    public function addBreedGroupList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\BreedGroup $breedGroupList)
    {
        $this->breedGroupList[] = $breedGroupList;
        return $this;
    }

    /**
     * Remove breedGroupList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\BreedGroup $breedGroupList
     */
    public function removeBreedGroupList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\BreedGroup $breedGroupList)
    {
        $this->breedGroupList->removeElement($breedGroupList);
    }

    /**
     * Get breedGroupList
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getBreedGroupList()
    {
        return $this->breedGroupList;
    }

    /**
     * Add breedList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breedList
     * @return Game
     */
    public function addBreedList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breedList)
    {
        $this->breedList[] = $breedList;
        return $this;
    }

    /**
     * Remove breedList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breedList
     */
    public function removeBreedList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breedList)
    {
        $this->breedList->removeElement($breedList);
    }

    /**
     * Get breedList
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getBreedList()
    {
        return $this->breedList;
    }

    /**
     * getAvailableBreedList
     *
     * @access public
     * @return void
     */
    public function getAvailableBreedList()
    {
        if (!isset($this->availableBreedList)) {
            $this->availableBreedList = array();
            $breedList = $this->getBreedList();
            foreach ($breedList as $breed) {
                if ($breed->getAvailable()) {
                    $this->availableBreedList[] = $breed;
                }
            }

            usort(
                $this->availableBreedList,
                function($a, $b) {
                    return strnatcasecmp($a->getName(), $b->getName());
                }
            );
        }

        return $this->availableBreedList;
    }

    /**
     * Gets the value of unitFeaturePublic
     *
     * @return boolean
     */
    public function getUnitFeaturePublic()
    {
        return $this->unitFeaturePublic;
    }

    /**
     * Sets the value of unitFeaturePublic
     *
     * @param boolean $unitFeaturePublic
     *
     * @return Game
     */
    public function setUnitFeaturePublic($unitFeaturePublic)
    {
        $this->unitFeaturePublic = $unitFeaturePublic;
        return $this;
    }

    /**
     * __toString
     *
     * @access public
     * @return string
     */
	public function __toString()
	{
		return $this->getName();
	}
}
