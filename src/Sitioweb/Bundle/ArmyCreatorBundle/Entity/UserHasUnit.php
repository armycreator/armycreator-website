<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserHasUnit
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserHasUnit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="smallint")
     */
    private $number;

    /**
     * user
     * 
     * @var User
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="userHasUnitList")
     */
    private $user;

    /**
     * Unit
     * 
     * @var Unit
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Unit", inversedBy="userHasUnitList")
     */
    private $unit;



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
     * Set number
     *
     * @param integer $number
     * @return UserHasUnit
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set user
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\User $user
     * @return UserHasUnit
     */
    public function setUser(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Sitioweb\Bundle\ArmyCreatorBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set unit
     *
     * @param \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unit
     * @return UserHasUnit
     */
    public function setUnit(\Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit 
     */
    public function getUnit()
    {
        return $this->unit;
    }
}