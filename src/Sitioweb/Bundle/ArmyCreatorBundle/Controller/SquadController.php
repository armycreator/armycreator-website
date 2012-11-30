<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JMS\SecurityExtraBundle\Annotation as Security;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType;

/**
 * SquadController
 * 
 * @uses Controller
 *
 * @Security\PreAuthorize("isFullyAuthenticated()")
 */
class SquadController extends Controller
{
    /**
     * Displays a form to create a new Squad entity.
     *
     * @Route("/army/{armySlug}/squad/new/{unitTypeSlug}", name="squad_new")
     * @Template()
     */
    public function newAction($armySlug, $unitTypeSlug)
    {
        // getting army
        $army = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($armySlug);
        if ($army === null) {
            throw new NotFoundHttpException('Army not found');
        }
        
        // getting breed
        $breed = $army->getBreed();

        // getting unitType
        $unitType = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:UnitType')->findOneBy(
            array(
                'breed' => $breed,
                'slug' => $unitTypeSlug
            )
        );
        if ($unitType === null) {
            throw new NotFoundHttpException('Unit type not found');
        }

        // security
        if ($this->getUser() != $army->getUser()) {
            throw new AccessDeniedException();
        }

        return array(
            'army' => $army,
            'breed' => $breed,
            'currentUnitType' => $unitType,
        );
    }
}

