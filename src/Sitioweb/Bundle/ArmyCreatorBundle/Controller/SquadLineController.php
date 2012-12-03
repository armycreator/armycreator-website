<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

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
        
        // getting breed
        $breed = $army->getBreed();

        $squad = new Squad();
        $squad->convertUnitGroup($unitGroup);

        $form = $this->createForm(new SquadType(), $squad);
        
        return array(
            'army' => $army,
            'breed' => $breed,
            'currentUnitType' => $unitGroup->getUnitType(),
            'form' => $form->createView(),
        );
    }
}

