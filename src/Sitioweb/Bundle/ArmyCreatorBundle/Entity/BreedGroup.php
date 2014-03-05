<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\BreedGroup
 *
 * @ORM\Entity
 */
class BreedGroup
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * game
     *
     * @var mixed
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Game", inversedBy="breedGroupList")
     */
    private $game;

	/**
	 * breedList
	 *
	 * @var mixed
	 * @access private
	 *
	 * @ORM\OneToMany(targetEntity="Breed", mappedBy="breedGroup")
     * @ORM\OrderBy({"name" = "ASC"})
	 */
	private $breedList;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->breedList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return BreedGroup
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
     * @return BreedGroup
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
     * Add breedList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed $breedList
     * @return BreedGroup
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

	public function __toString()
	{
		return $this->getName();
	}
}
