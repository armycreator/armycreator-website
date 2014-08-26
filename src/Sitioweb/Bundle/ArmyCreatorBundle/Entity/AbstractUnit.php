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
     * @Gedmo\Slug(fields={"name"}, unique_base="breed", unique=true)
     * @ORM\Column(length=255, unique=false, nullable=true)
     */
    private $slug;

    /**
     * points
     * @ORM\Column(name="points", type="integer")
     *
     * @var int
     * @access private
     */
    private $points;

    /**
     * breed
     *
     * @var Breed
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Breed", inversedBy="unitGroupList")
     */
    private $breed;

    /**
     * importedId
     *
     * @ORM\Column(type="integer", nullable=true)
     * @var mixed
     * @access private
     */
    private $importedId;

    /**
     * importedType
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var mixed
     * @access private
     */
    private $importedType;


    /**
     * unitType
     *
     * @var UnitType
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="UnitType", inversedBy="abstractUnitList")
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
        $this->points = 0;
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
     * getGroupType
     *
     * @access public
     * @return string
     */
    public function getGroupType()
    {
        return static::GROUP_TYPE;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return UnitStuff
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

    public function getNameAndPoints()
    {
        return $this->getName() . ' (' . $this->getPoints() . ' pts)';
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
     * Set imported type
     *
     * @param string $importedType
     * @return UnitType
     */
    public function setImportedType($importedType)
    {
        $this->importedType = $importedType;

        return $this;
    }

    /**
     * Get imported type
     *
     * @return string
     */
    public function getImportedType()
    {
        return $this->importedType;
    }
}
