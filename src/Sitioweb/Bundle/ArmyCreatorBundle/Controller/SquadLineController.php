<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JMS\SecurityExtraBundle\Annotation as Security;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\SquadType;

/**
 * SquadController
 * 
 * @uses Controller
 *
 * @Route("/army/{armySlug}/squadLine")
 * @Security\PreAuthorize("isFullyAuthenticated()")
 * @Breadcrumb("Home", route="homepage")
 * @Breadcrumb("My army list", route="army_list")
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
        $this->get("apy_breadcrumb_trail")->add('New ' . $unitGroup->getUnitType()->getName(), 'squad_new', array(
            'armySlug' => $army->getSlug(),
            'breedSlug' => $unitGroup->getBreed()->getSlug(),
            'unitTypeSlug' => $unitGroup->getUnitType()->getSlug()
        ));
        $this->get("apy_breadcrumb_trail")->add('New ' . $unitGroup->getName());
        
        // squad
        $squad = new Squad();
        $squad->mapUnitGroup($unitGroup, true);

        $form = $this->createForm(new SquadType(), $squad);

        return array(
            'army' => $army,
            'breed' => $army->getBreed(),
            'currentUnitType' => $unitGroup->getUnitType(),
            'form' => $form->createView(),
        );
    }

    /**
     * setArmyBreadCrumb
     *
     * @access public
     * @return void
     */
    public function setArmyBreadCrumb($army)
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

