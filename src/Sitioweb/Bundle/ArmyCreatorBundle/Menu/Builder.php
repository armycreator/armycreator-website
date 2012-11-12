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

        $menu->addChild('Home', array('route' => 'homepage'));
        $menu->addChild('Forum', array('uri' => '/forum/index.php'));
        if ($isAuth) {
            $menu->addChild('My army list', array('route' => 'army_list'));
            $menu->addChild('My collection', array('route' => ''));
        }
        $menu->addChild('Public army lists', array('route' => ''));
        $menu->addChild('Tools', array('route' => ''));
        $menu->addChild('Make a donation', array('uri' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=L7PK6V4R4LPHG'));

        /*
        $menu->addChild('About Me', array(
                    'route' => 'admin_breed',
                    'routeParameters' => array('id' => 42)
                    ));
        */

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

        $menu->addChild('My army list', array('route' => 'army_list'));
        $menu->addChild('My last army', array('route' => ''));
        $menu->addChild('Create a new army', array('route' => ''));
        $menu->addChild('My collection', array('route' => ''));
        $menu->addChild('Forum', array('uri' => '/forum/index.php'));
        $menu->addChild('Make a donation', array('uri' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=L7PK6V4R4LPHG'));

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

        if ($armyGroupList->isEmpty()) {
            $menu->addChild('No group');
        } else {
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

