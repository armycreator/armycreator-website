<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff
 *
 * @ORM\Table(indexes={@ORM\Index(name="import_idx", columns={"breed_id", "importedId","discriminator"})})

 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap({"weapon" = "Weapon", "equipement" = "Equipement"})
 */
abstract class Stuff
{
    CONST STUFF_WEAPON = 'weapon';
    CONST STUFF_EQUIPEMENT = 'equipement';

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
     * defaultPoints
     *
     * @var int
     * @access private
     *
     * @ORM\Column(name="defaultPoints", type="integer")
     */
    private $defaultPoints;

    /**
     * defaultAuto
     *
     * @var boolean
     * @access private
     *
     * @ORM\Column(name="auto", type="boolean")
     */
    private $defaultAuto;

    /**
     * importedId
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int
     * @access private
     */
    private $importedId;

    /**
     * breed
     *
     * @var Breed
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Breed", inversedBy="stuffList")
     */
    private $breed;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="object", nullable=true)
     */
    private $description;

    /**
     * Set description
     *
     * @param string $description
     * @return Equipement
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
	 * unitStuffList
	 *
	 * @var array<UnitStuff>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="UnitStuff", mappedBy="stuff")
	 */
	private $unitStuffList;

    public function __construct()
    {
        $this->unitStuffList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->defaultAuto = false;
        $this->defaultPoints = 0;
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
     * setImportedId
     *
     * @param int $importedId
     * @access public
     * @return Stuff
     */
    public function setImportedId($importedId)
    {
        $this->importedId = $importedId;
        return $this;
    }

    /**
     * getImportedId
     *
     * @access public
     * @return int
     */
    public function getImportedId()
    {
        return $this->importedId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Stuff
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
     * Add unitStuffList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff $unitStuffList
     * @return Stuff
     */
    public function addUnitStuffList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff $unitStuffList)
    {
        $this->unitStuffList[] = $unitStuffList;

        return $this;
    }

    /**
     * Remove unitStuffList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff $unitStuffList
     */
    public function removeUnitStuffList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff $unitStuffList)
    {
        $this->unitStuffList->removeElement($unitStuffList);
    }

    /**
     * Get unitStuffList
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getUnitStuffList()
    {
        return $this->unitStuffList;
    }

    /**
     * Set breed
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breed
     * @return Stuff
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
     * Gets the value of defaultPoints
     *
     * @return int
     */
    public function getDefaultPoints()
    {
        return $this->defaultPoints;
    }

    /**
     * Sets the value of defaultPoints
     *
     * @param int $defaultPoints
     *
     * @return Stuff
     */
    public function setDefaultPoints($defaultPoints)
    {
        $this->defaultPoints = $defaultPoints;
        return $this;
    }

    /**
     * Gets the value of defaultAuto
     *
     * @return boolean
     */
    public function getDefaultAuto()
    {
        return $this->defaultAuto;
    }

    /**
     * Sets the value of defaultAuto
     *
     * @param boolean $defaultAuto default auto Y/N
     *
     * @return Stuff
     */
    public function setDefaultAuto($defaultAuto)
    {
        $this->defaultAuto = $defaultAuto;
        return $this;
    }

    /**
     * getStuffType
     *
     * @abstract
     * @access public
     * @return string
     */
    public abstract function getStuffType();
}
