<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Weapon
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Weapon extends Stuff
{
    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=true)
     */
    private $type;

    /**
     * @var string $range
     *
     * @ORM\Column(name="range_", type="string", length=50, nullable=true)
     */
    private $range;

    /**
     * @var string $strenght
     *
     * @ORM\Column(name="strenght", type="string", length=50, nullable=true)
     */
    private $strenght;

    /**
     * @var string $armorPenetration
     *
     * @ORM\Column(name="armorPenetration", type="string", length=50, nullable=true)
     */
    private $armorPenetration;

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
     * Get armorPenetration
     *
     * @return string 
     */
    public function getArmorPenetration()
    {
        return $this->armorPenetration;
    }
}
