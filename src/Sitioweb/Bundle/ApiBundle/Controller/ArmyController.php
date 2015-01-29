<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

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
     * @Rest\View()
     */
    public function getArmyAction($id)
    {
        $army = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository('SitiowebArmyCreatorBundle:Army')
            ->find($id);

        return $army;
    }
}
