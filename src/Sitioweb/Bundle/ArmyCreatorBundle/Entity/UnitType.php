<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sitioweb\Bundle\ArmyCreatorBundle\Entity\Repository\UnitTypeRepository")
 */
class UnitType
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
     * importedId
     * 
     * @ORM\Column(type="integer")
     * @var mixed
     * @access private
     */
    private $importedId;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * position
     * 
     * @ORM\Column(type="integer")
     * @var int
     * @access private
     */
    private $position;

	/**
	 * unitList
	 * 
	 * @var array<Unit>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="Unit", mappedBy="unitType")
	 */
	private $unitList;

    /**
     * breed
     * 
     * @var Breed
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Breed", inversedBy="unitTypeList")
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
        $this->unitList = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param int $id
     * @return UnitType
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
     * Set position
     *
     * @param int $position
     * @return UnitType
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
     * Set name
     *
     * @param string $name
     * @return UnitType
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
     * Add unitList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unitList
     * @return UnitType
     */
    public function addUnitList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unitList)
    {
        $this->unitList[] = $unitList;
    
        return $this;
    }

    /**
     * Remove unitList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unitList
     */
    public function removeUnitList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unitList)
    {
        $this->unitList->removeElement($unitList);
    }

    /**
     * Get unitList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUnitList()
    {
        return $this->unitList;
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
}
