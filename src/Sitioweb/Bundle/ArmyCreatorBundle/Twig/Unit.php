<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Twig;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\SecurityContextInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity;

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
     * __construct
     *
     * @param ObjectManager $objectManager
     * @access public
     * @return void
     */
    public function __construct(ObjectManager $objectManager, SecurityContextInterface $securityContext)
    {
        $this->objectManager = $objectManager;
        $this->securityContext = $securityContext;
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
            'unit_feature' => new \Twig_Function_Method($this, 'unitFeature')
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
     * getName
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'unit';
    }

    /**
     * getUser
     *
     * @access private
     * @return User
     */
    private function getUser()
    {
        return $this->securityContext
            ->getToken()
            ->getUser();
    }
}
