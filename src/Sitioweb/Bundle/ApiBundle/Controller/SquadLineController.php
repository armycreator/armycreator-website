<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * putSquadlineAction
     *
     * @param mixed $squadLineId
     * @access public
     * @return void
     *
     *
     * @ApiDoc(
     *     section="SquadLine",
     *     description="Update a squad line"
     * )
     * @Rest\View(serializerGroups={"BaseArmy", "BaseSquad", "SquadDetail", "SquadLineDetail", "BaseUnit"})
     *
     * @ParamConverter("squadLine", class="SitiowebArmyCreatorBundle:SquadLine", options={"id" = "squadLine"})
     */
    public function putSquadlineAction(SquadLine $squadLine, Request $request)
    {
        $input = $this->get('jms_serializer')
            ->deserialize($request->getContent(), 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine', 'json');

        $squadLine->setNumber($input->getNumber())
            ->setInactive($input->isInactive());

        $this->get('doctrine.orm.default_entity_manager')
            ->flush();

        return $squadLine;
    }
}
