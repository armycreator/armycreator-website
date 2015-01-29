<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * ArmyGroupController
 *
 * @uses Controller
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class ArmyGroupController extends FOSRestController
{
    /**
     * getAction
     *
     * @access public
     * @return void
     *
     * @ApiDoc(
     *     section="Army groups",
     *     description="Get an army group"
     * )
     * @Rest\View()
     */
    public function getArmygroupAction($armyGroupId)
    {
        $armyGroup = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository('SitiowebArmyCreatorBundle:ArmyGroup')
            ->find($armyGroupId);

        return $armyGroup;
    }
}

