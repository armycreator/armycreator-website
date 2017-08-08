<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * SquadController
 *
 * @uses Controller
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class SquadController extends FOSRestController
{
    /**
     * getSquadAction
     *
     * @access public
     * @return void
     *
     * @ApiDoc(
     *     section="Squad",
     *     description="Get a squad"
     * )
     * @Rest\View(serializerGroups={"BaseArmy", "BaseSquad", "SquadDetail", "BaseUnit"})
     */
    public function getSquadAction($squadId)
    {
        $squad = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository('SitiowebArmyCreatorBundle:Squad')
            ->find($squadId);

        return $squad;
    }
}
