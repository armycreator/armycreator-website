<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\AbstractUnit
 *
 * @ORM\Table(indexes={@ORM\Index(name="import_idx", columns={"importedId","discriminator"})})
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap({"unit" = "Unit", "group" = "UnitGroup"})
 */
class AbstractUnit
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * slug
     * 
     * @var string
     * @access private
     *
     * @Gedmo\Slug(fields={"name"}, unique=false)
     * @ORM\Column(length=255, unique=false, nullable=true)
     */
    private $slug;

    /**
     * breed
     * 
     * @var Breed
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Breed", inversedBy="unitList")
     */
    private $breed;

    /**
     * importedId
     * 
     * @ORM\Column(type="integer")
     * @var mixed
     * @access private
     */
    private $importedId;

    /**
     * squadLineList
     * 
     * @var array<SquadLine>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="SquadLine", mappedBy="unit")
     */
    private $squadLineList;

    /**
     * unitType
     * 
     * @var UnitType
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="UnitType", inversedBy="unitList")
     */
    private $unitType;


    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->squadLineList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return AbstractUnit
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
     * setBreed
     *
     * @param Breed $breed
     * @access public
     * @return AbstractUnit
     */
    public function setBreed($breed)
    {
        $this->breed = $breed;
        return $this;
    }

    /**
     * getBreed
     *
     * @access public
     * @return Breed
     */
    public function getBreed()
    {
        return $this->breed;
    }

    /**
     * setUnitType
     *
     * @param UnitType $unitType
     * @access public
     * @return AbstractUnit
     */
    public function setUnitType($unitType)
    {
        $this->unitType = $unitType;
        return $this;
    }

    /**
     * getUnitType
     *
     * @access public
     * @return UnitType
     */
    public function getUnitType()
    {
        return $this->unitType;
    }

    /**
     * Set imported id
     *
     * @param int $id
     * @return UnitType
     */
    public function setImportedId($importedId)
    {
        $this->importedId = $importedId;
    
        return $this;
    }

    /**
     * Get imported id
     *
     * @return integer 
     */
    public function getImportedId()
    {
        return $this->importedId;
    }

    /**
     * Add squadLineList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine $squadLineList
     * @return Unit
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
     * getGroupType
     *
     * @access public
     * @return string
     */
    public function getGroupType()
    {
        return static::GROUP_TYPE;
    }

}
