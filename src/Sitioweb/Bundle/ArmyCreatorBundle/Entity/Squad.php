<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Squad
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
     * @var integer $position
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var \DateTime $createDate
     *
     * @ORM\Column(name="createDate", type="datetime")
     */
    private $createDate;

    /**
     * @var \DateTime $updateDate
     *
     * @ORM\Column(name="updateDate", type="datetime")
     */
    private $updateDate;

    /**
     * army
     * 
     * @var Army
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="Army", inversedBy="squadList")
     */
    private $army;

    /**
     * squadType
     * 
     * @var SquadType
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="SquadType", inversedBy="squadList")
     */
    private $squadType;

    /**
     * squadLineList
     * 
     * @var array<SquadLine>
     * @access private
     *
	 * @ORM\OneToMany(targetEntity="SquadLine", mappedBy="squad")
     */
    private $squadLineList;

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
     * @return Squad
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
     * Set position
     *
     * @param integer $position
     * @return Squad
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
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Squad
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    
        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Squad
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
    
        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set army
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army $army
     * @return Squad
     */
    public function setArmy(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army $army = null)
    {
        $this->army = $army;
    
        return $this;
    }

    /**
     * Get army
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army 
     */
    public function getArmy()
    {
        return $this->army;
    }

    /**
     * Set squadType
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadType $squadType
     * @return Squad
     */
    public function setSquadType(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadType $squadType = null)
    {
        $this->squadType = $squadType;
    
        return $this;
    }

    /**
     * Get squadType
     *
     * @return Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadType 
     */
    public function getSquadType()
    {
        return $this->squadType;
    }

    /**
     * Add squadLineList
     *
     * @param Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine $squadLineList
     * @return Squad
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
}