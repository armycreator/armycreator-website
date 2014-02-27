<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Builder
 *
 * @uses ContainerAware
 */
class Builder extends ContainerAware
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
        $isAuth = $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY');

        $menu = $factory->createItem('root');

        $menu->addChild('main_menu.home', array('route' => 'homepage'));
        $menu->addChild('main_menu.forum', array('route' => 'forum_index'));
        if ($isAuth) {
            $menu->addChild('main_menu.my_army_list', array('route' => 'army_list'));
            //$menu->addChild('main_menu.my_games', array('route' => ''));
        }
        //$menu->addChild('main_menu.public_lists', array('route' => ''));

        return $menu;
    }

    /**
     * secondMainMenu
     *
     * @param FactoryInterface $factory
     * @param array $options
     * @access public
     * @return void
     */
    public function secondMainMenu(FactoryInterface $factory, array $options)
    {
        $security = $this->container->get('security.context');
        $isAuth = $security->isGranted('IS_AUTHENTICATED_FULLY');

        $menu = $factory->createItem('root');

        if ($security->isGranted('ROLE_CONTRIB')) {
            $menu->addChild('main_menu.admin', array('route' => 'admin_game'));
        }

        if ($isAuth) {
            $menu->addChild('main_menu.my_collection', array('route' => 'user_collection'));
        }
        $menu->addChild('main_menu.tools', array('route' => 'toolbox_dice'));
        $menu->addChild('main_menu.donation', array('route' => 'donation'));
        $menu['main_menu.donation']->setLinkAttribute('target', '_blank');

        return $menu;
    }

    /**
     * breedShowMenu
     *
     * @param FactoryInterface $factory
     * @param array $options
     * @access public
     * @return void
     */
    public function breedShowMenu(FactoryInterface $factory, array $options)
    {
        $breed = $this->container->get('request')->get('breed');
        $game = $breed->getGame();
        $routeParameters = ['breed' => $breed->getSlug(), 'game' => $game->getCode()];

        $menu = $factory->createItem('root');

        $menu->addChild(
            'breed_show.menu.unitType_list',
            array(
                'route' => 'admin_breed_unittype',
                'routeParameters' => $routeParameters
            )
        );
        $menu->addChild(
            'breed_show.menu.unit_list',
            array(
                'route' => 'admin_breed_unit',
                'routeParameters' => $routeParameters
            )
        );
        $menu->addChild(
            'breed_show.menu.unitgroup',
            array(
                'route' => 'admin_breed_unitgroup',
                'routeParameters' => $routeParameters
            )
        );
        $menu->addChild(
            'breed_show.menu.stuff',
            array(
                'route' => 'admin_breed_stuff',
                'routeParameters' => $routeParameters
            )
        );

        return $menu;
    }

    /**
     * armyListMenu
     *
     * @param FactoryInterface $factory
     * @param array $options
     * @access public
     * @return void
     */
    public function armyListMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $user = $this->getUser();
        $armyGroupList = $user->getArmyGroupList();

        $menu->addChild('army_list.group_list.last_armies', array(
            'route' => 'army_list',
        ));

        $menu->addChild('army_list.group_list.all_armies', array(
            'route' => 'army_list',
            'routeParameters' => ['all' => true]
        ));

        if (!$armyGroupList->isEmpty()) {
            $menu->addChild('army_list.group_list.no_group', array(
                'route' => 'army_group_list',
                'routeParameters' => array('groupId' => 0)
            ));

            foreach ($armyGroupList as $armyGroup) {
                $menu->addChild($armyGroup->getName(), array(
                    'route' => 'army_group_list',
                    'routeParameters' => array('groupId' => $armyGroup->getId())
                ));
            }
        }
        $menu->addChild('+', array('route' => 'army_group_new'));

        return $menu;
    }

    /**
     * getUser
     *
     * @access private
     * @return void
     */
    private function getUser()
    {
        return $this->container->get('security.context')->getToken()->getUser();
    }
}
