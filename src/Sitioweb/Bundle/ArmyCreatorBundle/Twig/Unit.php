<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Twig;

use Doctrine\Common\Persistence\ObjectManager;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
     * tokenStorage
     *
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * __construct
     *
     * @param ObjectManager $objectManager
     * @access public
     * @return void
     */
    public function __construct(ObjectManager $objectManager, TokenStorageInterface $tokenStorage)
    {
        $this->objectManager = $objectManager;
        $this->tokenStorage = $tokenStorage;
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
        return $this->tokenStorage
            ->getToken()
            ->getUser();
    }
}
