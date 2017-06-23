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
        $menu = $factory->createItem('root');

        $menu->addChild('main_menu.home', array('route' => 'homepage'));
        $menu->addChild('main_menu.forum', array('route' => 'forum_index'));
        if ($this->isAuthenticated()) {
            $menu->addChild('main_menu.my_army_list', array('route' => 'army_list'));
            //$menu->addChild('main_menu.my_games', array('route' => ''));
        }
        $menu->addChild('main_menu.public_lists', array('route' => 'army_public_list'));

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
        $menu = $factory->createItem('root');

        $menu->addChild('main_menu.user_list', array('route' => 'user_list'));

        if ($this->isAuthenticated()) {
            $menu->addChild('main_menu.my_collection', array('route' => 'user_collection'));
        }
        $menu->addChild('main_menu.tools', array('route' => 'toolbox_dice'));
        $menu->addChild(
            'main_menu.donation',
            [
                'route' => 'donation',
                'routeParameters' => [
                    'cmd' => '_s-xclick',
                    'hosted_button_id' => 'L7PK6V4R4LPHG'
                ]
            ]
        );
        $menu['main_menu.donation']->setLinkAttribute('target', '_blank');

        foreach ($menu as $item) {
            $item->setLinkAttribute("onclick", "");
        }

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
            'breed_show.menu.stuff',
            array(
                'route' => 'admin_breed_stuff',
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

        return $menu;
    }

    /**
     * gameMenu
     *
     * @param FactoryInterface $factory
     * @param array $options
     * @access public
     * @return void
     */
    public function gameMenu(FactoryInterface $factory, array $options)
    {
        $game = $this->container->get('request')->get('game');
        $routeParameters = ['game' => $game->getCode()];

        $menu = $factory->createItem('root');

        $menu->addChild(
            'game_show.menu.breed_list',
            array(
                'route' => 'admin_breed',
                'routeParameters' => $routeParameters
            )
        );
        $menu->addChild(
            'game_show.menu.stuff_list',
            array(
                'route' => 'admin_game_stuff',
                'routeParameters' => $routeParameters
            )
        );
        $menu->addChild(
            'game_show.menu.breed_group',
            array(
                'route' => 'breedgroup',
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
        $request = $this->container->get('request');
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

        if ($request->query->get('all')) {
            $menu['army_list.group_list.last_armies']->setCurrent(false);
            $menu['army_list.group_list.all_armies']->setCurrent(true);
        }

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
        $tokenStorage = $this->container->get('security.token_storage');
        return $tokenStorage && $tokenStorage->getToken() ? $tokenStorage->getToken()->getUser() : null;
    }

    private function isAuthenticated()
    {
        $tokenStorage = $this->container->get('security.token_storage');
        $authChecker = $this->container->get('security.authorization_checker');
        return $tokenStorage && $tokenStorage->getToken() && $authChecker->isGranted('IS_AUTHENTICATED_FULLY');
    }
}
