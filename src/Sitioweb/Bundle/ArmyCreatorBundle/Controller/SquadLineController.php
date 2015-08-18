<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation as Security;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit;
use Sitioweb\Bundle\ArmyCreatorBundle\Event\GameEvent;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\SquadType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\SquadLineType;

/**
 * SquadController
 *
 * @uses Controller
 *
 * @Route("/army/{armySlug}/squadLine")
 * @Security\PreAuthorize("isFullyAuthenticated()")
 * @Breadcrumb("breadcrumb.home", route="homepage")
 * @Breadcrumb("breadcrumb.army_list", route="army_list")
 */
class SquadLineController extends Controller
{
    /**
     * selectedUnitNewAction
     *
     * @Route("/new/{unitGroupId}", requirements={"id" = "\d+"}, name="squad_line_new")
     * @Template()
     */
    public function newAction($armySlug, $unitGroupId)
    {
        // getting army
        $army = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($armySlug);
        if ($army === null) {
            throw new NotFoundHttpException('Army not found');
        }

        $unitGroup = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:UnitGroup')->find($unitGroupId);
        if ($unitGroup === null) {
            throw new NotFoundHttpException('Unit group not found');
        }

        // breadcrumb
        $this->setArmyBreadCrumb($army);
        $urlParams = array(
            'armySlug' => $army->getSlug(),
            'breedSlug' => $unitGroup->getBreed()->getSlug(),
            'unitTypeSlug' => $unitGroup->getUnitType()->getSlug()
        );
        $this->get("apy_breadcrumb_trail")->add(
            $unitGroup->getUnitType()->getName(),
            'squad_new',
            $urlParams
        );
        $this->get("apy_breadcrumb_trail")->add($unitGroup->getName());

        // squad
        $squad = new Squad();
        $squad->mapUnitGroup($unitGroup, true);

        $form = $this->createForm(new SquadType($unitGroup->getUnitType()->getBreed()), $squad);

        return array(
            'army' => $army,
            'breed' => $army->getBreed(),
            'currentUnitType' => $unitGroup->getUnitType(),
            'form' => $form->createView(),
            'externalUser' => false,
        );
    }

    /**
     * linkUnitStuff
     *
     * @access public
     * @return void
     *
     * @Route("/link/{id}/{unitId}", name="squad_link_unit_stuff")
     * @Template()
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"armySlug" = "slug"}})
     * @ParamConverter("squad", class="SitiowebArmyCreatorBundle:Squad", options={ "id" = "id" })
     * @ParamConverter("unit", class="SitiowebArmyCreatorBundle:Unit", options={ "id" = "unitId" })
     */
    public function linkUnitStuffAction(Army $army, Squad $squad, Unit $unit)
    {
        $squadLine = new SquadLine;
        $squadLine->setUnit($unit)
            ->setSquad($squad);
        $squadLine->addEmptySquadLineStuff();

        $form = $this->createForm(new SquadLineType(), $squadLine);

        $request = $this->get('request');
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $squadLine->preUpdate();
                //    $em->remove($squadLine);
                //} else {
                if ($squadLine->getNumber() > 0) {
                    $em->persist($squadLine);
                }

                // dispatch event
                $this->get('event_dispatcher')
                    ->dispatch(
                        'armycreator.event.squad_line.link',
                        new GameEvent($army->getBreed()->getGame())
                    );

                $em->flush();
                return $this->redirect($this->generateUrl('army_detail', array('slug' => $army->getSlug())));
            }
        }

        // Breadcrumb
        $this->setArmyBreadCrumb($army);
        $this->get("apy_breadcrumb_trail")->add(
            $unit->getName(),
            'squad_link_unit',
            ['armySlug' =>  $army->getSlug(), 'id' => $squad->getId()]
        );

        $tmp = $this->get('translator')
            ->trans('breadcrumb.squad_link.select_stuff.%unit%', ['%unit%' => $unit->getName()]);
        $this->get("apy_breadcrumb_trail")->add($tmp);


        return array(
            'army' => $army,
            'squad' => $squad,
            'unit' => $unit,
            'squadLine' => $squadLine,
            'breed' => $army->getBreed(),
            'form' => $form->createView(),
            'externalUser' => false,
        );
    }

    /**
     * changeActiveStatusAction
     *
     * @param SquadLine $squadLine
     * @param mixed $isInactive
     * @access public
     * @return void
     *
     * @Route("/active_status/{id}/{isInactive}", name="squad_line_changeActiveStatus")
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"armySlug" = "slug"}})
     * @ParamConverter("squadLine", class="SitiowebArmyCreatorBundle:SquadLine", options={ "id" = "id" })
     */
    public function changeActiveStatusAction(Army $army, SquadLine $squadLine, $isInactive)
    {
        $squadLine->setInactive($isInactive);
        $this->get('doctrine')->getManager()->flush();

        $utSlug = $squadLine->getSquad()->getUnitType()->getSlug();

        $url = $this->generateUrl('army_detail', ['slug' => $army->getSlug()])
            . '#ut-' . $utSlug;

        return $this->redirect($url);
    }

    /**
     * setArmyBreadCrumb
     *
     * @access private
     * @return void
     */
    private function setArmyBreadCrumb($army)
    {
        // Breadcrumb
        if ($army->getArmyGroup() !== null) {
            $this->get("apy_breadcrumb_trail")->add(
                $army->getArmyGroup()->getName(),
                'army_group_list',
                array('groupId' =>  $army->getArmyGroup()->getId())
            );
        }
        $this->get("apy_breadcrumb_trail")->add($army->getName(), 'army_detail', array('slug' =>  $army->getSlug()));
    }
}

