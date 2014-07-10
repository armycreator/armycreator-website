<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Model\FArm;

class WeaponDescription
{
    private $rangeStrength;

    /**
     * __construct
     *
     * @access public
     */
    public function __construct()
    {
        $this->rangeStrength = [];
    }

    /**
     * setRangeStrength
     *
     * @access public
     * @return WeaponDescription
     */
    public function setRangeStrength($range, $strength)
    {
        $this->rangeStrength[$range] = $strength;

        return $this;
    }

    /**
     * getAllRangeStrength
     *
     * @access public
     * @return array
     */
    public function getAllRangeStrength()
    {
        return $this->rangeStrength;
    }
}
