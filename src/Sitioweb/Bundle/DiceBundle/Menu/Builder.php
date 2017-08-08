<?php

namespace Sitioweb\Bundle\DiceBundle\Menu;

use Knp\Menu\FactoryInterface;

/**
 * Builder
 */
class Builder
{
    /**
     * mainMenu
     *
     * @param FactoryInterface $factory
     * @param array $options
     * @access public
     * @return void
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('dice.menu.launcher', array('route' => 'toolbox_dice'));
        $menu->addChild('dice.menu.weapon_statistic', array('route' => 'toolbox_weapon_statistic'));
        $menu->addChild('dice.menu.infight_statistic', array('route' => 'toolbox_infight_statistic'));

        return $menu;
    }
}


