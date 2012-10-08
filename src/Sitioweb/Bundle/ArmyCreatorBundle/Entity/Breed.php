<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed
 *
 * @ORM\Entity
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
	 * unitList
	 * 
	 * @var array
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="AbstractUnit", mappedBy="breed")
	 */
	private $unitList;


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
     * Add unitList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\AbstractUnit $unitList
     * @return Breed
     */
    public function addUnitList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\AbstractUnit $unitList)
    {
        $this->unitList[] = $unitList;
    
        return $this;
    }

    /**
     * Remove unitList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\AbstractUnit $unitList
     */
    public function removeUnitList(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\AbstractUnit $unitList)
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
}