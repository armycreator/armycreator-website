<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
 * @Route("/army/{armySlug}/squad")
 * @Security\PreAuthorize("isFullyAuthenticated()")
 * @Breadcrumb("breadcrumb.home", route="homepage")
 * @Breadcrumb("breadcrumb.army_list", route="army_list")
 */
class SquadController extends Controller
{
    /**
     * Displays a form to create a new Squad entity.
     *
     * @Route("/new/{breedSlug}/{unitTypeSlug}", name="squad_new")
     * @Template()
     */
    public function newAction($armySlug, $breedSlug, $unitTypeSlug)
    {
        $em = $this->get('doctrine')->getManager();

        // getting army
        $army = $em->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($armySlug);
        if ($army === null) {
            throw new NotFoundHttpException('Army not found');
        }
        
        // getting breed
        $breed = $em->getRepository('SitiowebArmyCreatorBundle:Breed')
                    ->findOneBySlug($breedSlug);
        if ($army === null) {
            throw new NotFoundHttpException('Army not found');
        }

        // getting unitType
        $unitType = $em->getRepository('SitiowebArmyCreatorBundle:UnitType')->findOneBy(
            array(
                'breed' => $breed,
                'slug' => $unitTypeSlug
            )
        );
        if ($unitType === null) {
            throw new NotFoundHttpException('Unit type not found');
        }

        // breadcrumb
        $this->setArmyBreadCrumb($army);
        $tmp = $this->get('translator')
                    ->trans('breadcrumb.squad_new.%unit_type%', array('unit_type' => $unitType->getName()));
        $this->get("apy_breadcrumb_trail")->add($tmp);

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
     * createAction
     *
     * @param mixed $armySlug
     * @access public
     * @return void
     *
     * @Route("/create/{unitGroupId}", requirements={"id" = "\d+"}, name="squad_create")
     * @Method("post")
     * @Template("SitiowebArmyCreatorBundle:SquadLine:new.html.twig")
     */
    public function createAction($armySlug, $unitGroupId)
    {
        $request = $this->getRequest();

        // getting army
        $army = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($armySlug);
        if ($army === null) {
            throw new NotFoundHttpException('Army not found');
        }
        
        // getting unit group
        $unitGroup = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:UnitGroup')->find($unitGroupId);
        if ($unitGroup === null) {
            throw new NotFoundHttpException('Unit group not found');
        }
       
        $entity  = new Squad();
        $entity->mapUnitGroup($unitGroup, true);
        

        $form    = $this->createForm(new SquadType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->preUpdate();

            if (!$entity->getSquadLineList()->isEmpty()) {
                $entity->setArmy($army);
                $em->persist($entity);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('army_detail', array('slug' => $army->getSlug())));
        }

        return array(
            'entity' => $entity,
            'army' => $army,
            'breed' => $army->getBreed(),
            'currentUnitType' => $unitGroup->getUnitType(),
            'form' => $form->createView(),
        );
    }

    /**
     * editAction
     *
     * @access public
     * @return void
     *
     * @Route("/edit/{id}", name="squad_edit")
     * @Template()
     */
    public function editAction($armySlug, $id)
    {
        // getting army
        $army = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($armySlug);
        if ($army === null) {
            throw new NotFoundHttpException('Army not found');
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Squad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Squad entity.');
        }

        // breadcrumb
        $this->setArmyBreadCrumb($army);
        $tmp = $this->get('translator')
                    ->trans('breadcrumb.squad_edit.%squad_name%', array('squad_name' => $entity->getName()));
        $this->get("apy_breadcrumb_trail")->add($tmp);

        $entity->addEmptySquadLine();
        $editForm = $this->createForm(new SquadType(), $entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'breed'        => $army->getBreed(),
            'army'        => $army,
            'entity'      => $entity,
            'currentUnitType' => $entity->getUnitType(),
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Squad entity.
     *
     * @Route("/{id}/update", name="squad_update")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:Squad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Squad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Squad entity.');
        }

        $entity->addEmptySquadLine();
        $editForm = $this->createForm(new SquadType(), $entity);
        $editForm->bind($request);
        $deleteForm = $this->createDeleteForm($entity->getId());

        if ($editForm->isValid()) {
            $entity->preUpdate();
            if ($entity->getSquadLineList()->isEmpty()) {
                $em->remove($entity);
            } else {
                $em->persist($entity);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('army_detail', array('slug' => $entity->getArmy()->getSlug())));
        }
        

        return array(
            'army'      => $entity->getArmy(),
            'entity'      => $entity,
            'currentUnitType' => $entity->getUnitType(),
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Squad entity.
     *
     * @Route("/{id}/delete", name="squad_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:Squad')->find($id);
            $army = $entity->getArmy();

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Squad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        if (isset($army)) {
            return $this->redirect($this->generateUrl('army_detail', array('slug' => $army->getSlug())));
        } else {
            return $this->redirect($this->generateUrl('army_list'));
        }
    }

    /**
     * createDeleteForm
     *
     * @param int $id
     * @access private
     * @return void
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
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

