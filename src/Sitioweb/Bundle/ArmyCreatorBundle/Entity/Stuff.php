<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff
 *
 * @ORM\Table(indexes={@ORM\Index(name="import_idx", columns={"breed_id", "importedId","discriminator"})})
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap({"weapon" = "Weapon", "equipement" = "Equipement"})
 */
class Stuff
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
}
