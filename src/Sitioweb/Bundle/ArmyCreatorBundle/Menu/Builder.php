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
        $menu->addChild('main_menu.forum', array('uri' => '/forum/index.php'));
        if ($isAuth) {
            $menu->addChild('main_menu.my_army_list', array('route' => 'army_list'));
            $menu->addChild('main_menu.my_games', array('route' => ''));
        }

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
        $isAuth = $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY');

        $menu = $factory->createItem('root');

        if ($isAuth) {
            $menu->addChild('main_menu.my_collection', array('route' => ''));
        }
        $menu->addChild('main_menu.public_lists', array('route' => ''));
        $menu->addChild('main_menu.tools', array('route' => 'toolbox_dice'));
        $menu->addChild('main_menu.donation', array('uri' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=L7PK6V4R4LPHG'));

        return $menu;
    }

    /**
     * homepageMenu
     *
     * @param FactoryInterface $factory
     * @param array $options
     * @access public
     * @return void
     */
    public function homepageMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('homepage_menu.my_army_list', array('route' => 'army_list'));
        $menu->addChild('homepage_menu.last_army', array('route' => ''));
        $menu->addChild('homepage_menu.create_army', array('route' => ''));
        $menu->addChild('homepage_menu.my_collection', array('route' => ''));
        $menu->addChild('homepage_menu.forum', array('uri' => '/forum/index.php'));
        $menu->addChild('homepage_menu.donation', array('uri' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=L7PK6V4R4LPHG'));

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

        $user = $this->container->get('security.context')->getToken()->getUser();
        $armyGroupList = $user->getArmyGroupList();

        $menu->addChild('army_list.group_list.all_armies', array(
            'route' => 'army_list'
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
}

