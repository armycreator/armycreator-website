<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JMS\SecurityExtraBundle\Annotation as Security;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\SquadType;

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

    /**
     * selectedUnitNewAction
     *
     * @Route("/army/{armySlug}/squad/new/unit/{id}", requirements={"id" = "\d+"}, name="selected_unit_squad_new")
     * @Template()
     */
    public function selectedUnitNewAction($armySlug, $id)
    {
        // getting army
        $army = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($armySlug);
        if ($army === null) {
            throw new NotFoundHttpException('Army not found');
        }

        $unit = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:AbstractUnit')->find($id);
        if ($unit === null) {
            throw new NotFoundHttpException('Unit not found');
        }
        
        // getting breed
        $breed = $army->getBreed();

        // TODO : C'est en fait probablement plutot un "Form\AbstractUnitType" qu'il faudrait faire, avec une collection de Unit, qui a une collection de UnitStuff. Quoi que du coup ce n'est pas les valeurs que l'on souhaite modifier non plus... Je pense finalement que l'on risque de le faire a la mano... Sinon, il faudrait peut-etre que Squad et AbstractUnit implemente la meme interface, cela permettrait de creer le formulaire avec un objet et de le binder avec un autre pour la creation, mais ca fait decouler plein d'interfaces derriere...
        if ($unit->getGroupType() == 'unit') {
            $unitList = array(
                array(
                    'unit' => $unit,
                    'number' => 1
                )
            );
        } else {
            $unitHasUnitGroupList = $unit->getUnitHasUnitGroupList();
            foreach ($unitHasUnitGroupList as $unitHasUnitGroup) {
                $unitList[] = array(
                    'unit' => $unitHasUnitGroup->getUnit(),
                    'number' => $unitHasUnitGroup->getUnitNumber()
                );
            }
        }
        ladybug_dump($unitList);
        

        $squad = new Squad();
        /*
        foreach ($unitList as $tmpUnit) {
            $squadLine = new SquadLine();
            $squadLine->setUnit($tmpUnit->getUnit());
            $squadLine->setNumber($tmpUnit->getUnitNumber());
            $squad->addSquadLineList($squadLine);
        }
        */
        $form = $this->createForm(new SquadType($unitList), array('squadLineList' => $unitList));
        
        return array(
            'army' => $army,
            'breed' => $breed,
            'currentUnitType' => $unit->getUnitType(),
            'form' => $form->createView(),
        );
    }
}

