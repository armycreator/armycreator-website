<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * slug
     * 
     * @var string
     * @access private
     *
     * @Gedmo\Slug(fields={"name"}, unique=false, updatable=true)
     * @ORM\Column(length=255)
     */
    private $slug;

    /**
     * position
     * 
     * @ORM\Column(type="integer")
     * @var int
     * @access private
     */
    private $position;

    /**
     * color
     * @ORM\Column(type="string", length=10, nullable=true)
     * 
     * @var string
     * @access private
     */
    private $color;

	/**
	 * unitList
	 * 
	 * @var array<Unit>
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="AbstractUnit", mappedBy="unitType")
     * @ORM\OrderBy({"name" = "ASC"})
	 */
	private $unitList;

    /**
     * visibleUnitList
     * 
     * @var array
     * @access private
     */
    private $visibleUnitList = null;

    /**
     * squadList
     * 
     * @var array<Squad>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="Squad", mappedBy="unitType")
     */
    private $squadList;

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
        $this->squadList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * setColor
     *
     * @param string $color
     * @access public
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * getColor
     *
     * @access public
     * @return string
     */
    public function getColor()
    {
        return $this->color;
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
     * getVisibleUnitList
     *
     * @access public
     * @return array
     */
    public function getVisibleUnitList()
    {
        if ($this->visibleUnitList === null) {
            $this->visibleUnitList = array();
            $tmpUnitList = $this->getUnitList();
            foreach ($tmpUnitList as $unit) {
                if (!($unit instanceof Unit) || $unit->getViewInList()) {
                    $this->visibleUnitList[] = $unit;
                }
            }
        }
        return $this->visibleUnitList;
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
     * Add squadList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squadList
     * @return UnitType
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
}
