<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Twig;

use \Doctrine\Common\Persistence\ObjectManager;

use \Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine;


class Squad extends \Twig_Extension
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
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
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
            new \Twig_SimpleFunction('canChooseNumber', [$this, 'canChooseNumber']),
        );
    }

    /**
     * canChooseNumber
     *
     * @param SquadLine $squadLine
     * @access public
     * @return string
     */
    public function canChooseNumber(SquadLine $squadLine)
    {
        $group = $squadLine->getSquad()->getUnitGroup();
        $unit = $squadLine->getUnit();

        $uhug = $this->objectManager
            ->getRepository('SitiowebArmyCreatorBundle:UnitHasUnitGroup')
            ->findOneBy(['unit' => $unit, 'group' => $group]);

        if ($uhug) {
            return $uhug->getCanChooseNumber();
        }

        return true;
    }
}
