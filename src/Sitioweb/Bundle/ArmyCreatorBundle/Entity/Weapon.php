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
     * getStuffType
     *
     * @access public
     * @return string
     */
    public function getStuffType()
    {
        return 'weapon';
    }
}
