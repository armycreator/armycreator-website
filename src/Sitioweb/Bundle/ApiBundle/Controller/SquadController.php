<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

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
     * @Rest\View(serializerGroups={"BaseArmy", "SquadDetail"})
     */
    public function getSquadAction($squadId)
    {
        $squad = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository('SitiowebArmyCreatorBundle:Squad')
            ->find($squadId);

        return $squad;
    }
}
