<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * ArmyController
 *
 * @uses Controller
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class ArmyController extends FOSRestController
{
    /**
     * getAction
     *
     * @access public
     * @return void
     *
     * @ApiDoc(
     *     section="Armies",
     *     description="Get an army"
     * )
     * @Rest\View(serializerGroups={"BaseArmy", "ArmyDetail"})
     */
    public function getArmyAction($armyId)
    {
        $army = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository('SitiowebArmyCreatorBundle:Army')
            ->find($armyId);

        return $army;
    }
}
