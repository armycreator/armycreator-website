<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserHasUnit
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserUnitFeature
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
     * feature
     *
     * @var mixed
     * @access private
     *
     * @ORM\Column(name="feature", type="object", nullable=true)
     */
    private $feature;

    /**
     * user
     *
     * @var User
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="userUnitFeatureList")
     */
    private $user;

    /**
     * Unit
     *
     * @var Unit
     * @access private
	 *
	 * @ORM\ManyToOne(targetEntity="Unit")
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
     * Gets the value of feature
     *
     * @return mixed
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * Sets the value of feature
     *
     * @param mixed $feature
     *
     * @return UserUnitFeature
     */
    public function setFeature($feature)
    {
        $this->feature = $feature;
        return $this;
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
