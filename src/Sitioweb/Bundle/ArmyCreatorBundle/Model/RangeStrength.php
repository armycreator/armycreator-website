<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Model;

class RangeStrength
{
    private $range;

    private $strength;

    public function __construct($range = null, $strength = null)
    {
        $this->setRange($range)
            ->setStrength($strength);
    }

    /**
     * Gets the value of range
     *
     * @return int
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * Sets the value of range
     *
     * @param int $range range
     *
     * @return RangeStrength
     */
    public function setRange($range)
    {
        $this->range = $range;
        return $this;
    }

    /**
     * Gets the value of strength
     *
     * @return int
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * Sets the value of strength
     *
     * @param int $strength strength
     *
     * @return RangeStrength
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;
        return $this;
    }

    /**
     * __toString
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        if ($this->range && $this->strength) {
            return $this->range . ': ' . $this->strength;
        }
        return '';
    }
}
