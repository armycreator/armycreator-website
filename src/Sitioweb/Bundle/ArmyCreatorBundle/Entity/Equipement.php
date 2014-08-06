<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\Equipement
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Equipement extends Stuff
{
    /**
     * getStuffType
     *
     * @access public
     * @return string
     */
    public function getStuffType()
    {
        return 'equipement';
    }
}
