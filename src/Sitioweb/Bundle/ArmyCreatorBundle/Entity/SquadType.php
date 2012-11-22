<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SquadType
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string $image
     *
     * @ORM\Column(name="image", type="string", length=50)
     */
    private $image;

    /**
     * squadList
     * 
     * @var array<Squad>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="Squad", mappedBy="squadType")
     */
    private $squadList;



    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->squadList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return SquadType
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
     * Set image
     *
     * @param string $image
     * @return SquadType
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
     * Add squadList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad $squadList
     * @return SquadType
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
