<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Twig;

use Doctrine\Common\Persistence\ObjectManager;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity;
use Sitioweb\Bundle\ArmyCreatorBundle\UserService;

class Unit extends \Twig_Extension
{
    /**
     * objectManager
     *
     * @var ObjectManager
     * @access private
     */
    private $objectManager;

    /**
     * UserService
     *
     * @var UserService
     */
    private $userService;

    /**
     * __construct
     *
     * @param ObjectManager $objectManager
     * @access public
     * @return void
     */
    public function __construct(ObjectManager $objectManager, UserService $userService)
    {
        $this->objectManager = $objectManager;
        $this->userService = $userService;
    }

    /**
     * getFunctions
     *
     * @access public
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('unit_feature', [$this, 'unitFeature'])
        );
    }

    public function unitFeature(Entity\Unit $unit)
    {
        $userFeature = $this->objectManager
            ->getRepository('SitiowebArmyCreatorBundle:UserUnitFeature')
            ->findOneBy(['unit' => $unit, 'user' => $this->getUser()]);

        if ($userFeature) {
            return $userFeature->getFeature();
        }

        if ($unit->getBreed()->getGame()->getUnitFeaturePublic()) {
            return $unit->getFeature();
        }
    }

    /**
     * getUser
     *
     * @access private
     * @return User
     */
    private function getUser()
    {
        return $this->userService
            ->getArmyCreatorUser();
    }
}
