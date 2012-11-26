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
            $menu->addChild('My games', array('route' => 'homepage'));
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
            $menu->addChild('My collection', array('route' => 'army_list'));
        }
        $menu->addChild('Public lists', array('route' => 'homepage'));
        $menu->addChild('Tools', array('route' => 'homepage'));
        $menu->addChild('Donation', array('uri' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=L7PK6V4R4LPHG'));

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

        $menu->addChild('All armies', array(
            'route' => 'army_list'
        ));

        if (!$armyGroupList->isEmpty()) {
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

