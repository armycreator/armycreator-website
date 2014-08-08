<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Model\Warhammer;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Weapon
 */
class Weapon
{
    /**
     * @var string $type
     */
    private $type;

    /**
     * @var string $range
     */
    private $range;

    /**
     * @var string $strenght
     */
    private $strenght;

    /**
     * @var string $armorPenetration
     */
    private $armorPenetration;

    /**
     * @var string $rule
     */
    private $rule;

    /**
     * Set type
     *
     * @param string $type
     * @return Weapon
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set range
     *
     * @param string $range
     * @return Weapon
     */
    public function setRange($range)
    {
        $this->range = $range;

        return $this;
    }

    /**
     * Get range
     *
     * @return string
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * Set strenght
     *
     * @param string $strenght
     * @return Weapon
     */
    public function setStrenght($strenght)
    {
        $this->strenght = $strenght;

        return $this;
    }

    /**
     * Get strenght
     *
     * @return string
     */
    public function getStrenght()
    {
        return $this->strenght;
    }

    /**
     * Set armorPenetration
     *
     * @param string $armorPenetration
     * @return Weapon
     */
    public function setArmorPenetration($armorPenetration)
    {
        $this->armorPenetration = $armorPenetration;

        return $this;
    }

    /**
     * Set rule
     *
     * @param string $rule
     * @return Equipement
     */
    public function setRule($rule)
    {
        return $this->rule = $rule;
    }

    /**
     * Get rule
     *
     * @return string
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Get armorPenetration
     *
     * @return string
     */
    public function getArmorPenetration()
    {
        return $this->armorPenetration;
    }

    /**
     * __toString
     *
     * @access public
     * @return void
     */
    public function __toString()
    {
        $desc = '';

        if ($this->getType()) {
            $desc .= $this->getType() . ' - ';
        }

        if ($this->getRange()) {
            $desc .= 'P ' . $this->getRange() . ' - ';
        }

        if ($this->getStrenght()) {
            $desc .= 'F ' . $this->getStrenght() . ' - ';
        }

        if ($this->getArmorPenetration()) {
            $desc .= 'PA ' . $this->getArmorPenetration() . ' - ';
        }

        if ($this->getRule()) {
            $desc .= $this->getRule() . ' - ';
        }

        $desc = substr($desc, 0, -3);

        return $desc ?: '';
    }
}
