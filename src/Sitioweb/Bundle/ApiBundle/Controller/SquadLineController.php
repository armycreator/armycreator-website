<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * SquadLineController
 *
 * @uses Controller
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class SquadLineController extends FOSRestController
{
    /**
     * getSquadAction
     *
     * @access public
     * @return void
     *
     * @ApiDoc(
     *     section="SquadLine",
     *     description="Get a squad line"
     * )
     * @Rest\View(serializerGroups={"BaseArmy", "BaseSquad", "SquadDetail", "SquadLineDetail", "BaseUnit"})
     */
    public function getSquadlineAction($squadLineId)
    {
        $squadLine = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository('SitiowebArmyCreatorBundle:SquadLine')
            ->find($squadLineId);

        return $squadLine;
    }
}
