<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\UnitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Unit controller.
 *
 * @Route("/admin/{game}/{breed}/unit")
 * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
 * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
 */
class UnitController extends Controller
{
    /**
     * Creates a new Unit entity.
     *
     * @Route("/create", name="unit_create")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:Unit:new.html.twig")
     */
    public function createAction(Request $request, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $entity  = new Unit();
        $unitHasUnitGroup = new UnitHasUnitGroup();
        $unitHasUnitGroup->setUnit($entity);

        $form = $this->createForm(UnitType::class, $entity, ['breed' => $breed]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setBreed($breed);

            // get group
            if ($request->get('group')) {
                $unitGroup = $em->getRepository('SitiowebArmyCreatorBundle:UnitGroup')
                                ->findOneBySlug($request->get('group'));
                $mainUnit = false;
            } else {
                $unitGroup = null;
            }

            $doNotCreateUnitGroup = $form->get('doNotCreateUnitGroup')->getData();
            if (!$unitGroup && !$doNotCreateUnitGroup) {
                $unitGroup = UnitGroup::createFromUnit($entity);
                $mainUnit = true;
            }

            if (isset($unitGroup)) {
                $unitHasUnitGroup->setGroup($unitGroup)
                                ->setMainUnit($mainUnit);

                $em->persist($unitGroup);
                $em->persist($unitHasUnitGroup);
            } else {
                $entity->removeUnitHasUnitGroupList($unitHasUnitGroup);
            }

            $em->persist($entity);
            $em->flush();

            if ($form->get('createAndAdd')->isClicked()) {
                $url = $this->generateUrl(
                        'unit_new',
                        [
                            'breed' => $breed->getSlug(),
                            'game' => $breed->getGame()->getCode(),
                            'unitTypeSlug' => $entity->getUnitType()->getSlug(),
                        ]
                    );
                return $this->redirect($url);
            } else {
                return $this->redirect($this->getArmyShowUrl($breed, $entity));
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Unit entity.
     *
     * @Route("/new/{unitTypeSlug}", name="unit_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Breed $breed, $unitTypeSlug = null)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        // getting unitType
        $em = $this->get('doctrine')->getManager();
        $unitType = $em->getRepository('SitiowebArmyCreatorBundle:UnitType')->findOneBy(
            array(
                'breed' => $breed,
                'slug' => $unitTypeSlug
            )
        );

        $entity = new Unit();
        $entity->setUnitType($unitType)
                ->setBreed($breed);
        /*
        $unitHasUnitGroup = new UnitHasUnitGroup();
        $unitHasUnitGroup->setUnit($entity);
        */

        $form = $this->createForm(UnitType::class, $entity, ['breed' => $breed]);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Unit entity.
     *
     * @Route("/{id}", name="unit_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Unit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Unit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Unit entity.
     *
     * @Route("/{unit}/edit", name="unit_edit")
     * @ParamConverter("unit", class="SitiowebArmyCreatorBundle:Unit", options={"mapping": {"unit" = "slug"}})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Unit $unit, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(UnitType::class, $unit, ['breed' => $breed]);
        $deleteForm = $this->createDeleteForm($unit->getId());

        return array(
            'unit'      => $unit,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Unit entity.
     *
     * @Route("/{id}/update", name="unit_update")
     * @ParamConverter("unit", class="SitiowebArmyCreatorBundle:Unit", options={"mapping": {"id" = "id"}})
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:Unit:edit.html.twig")
     */
    public function updateAction(Request $request, Unit $entity, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(UnitType::class, $entity, ['breed' => $breed]);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            // dirty fix because description object are compared by reference, not by value
            // @see http://doctrine-orm.readthedocs.org/en/latest/reference/basic-mapping.html
            $feature = $entity->getFeature();
            if (is_object($feature)) {
                $entity->setFeature(clone $feature);
            }

            $entity->setBreed($breed);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->getArmyShowUrl($breed, $entity));
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'unit'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Unit entity.
     *
     * @Route("/{id}/delete", name="unit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Breed $breed, $id)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:Unit')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Unit entity.');
            }

            foreach ($entity->getUnitHasUnitGroupList() as $unitHasUnitGroup) {
                $em->remove($unitHasUnitGroup);
            }

            foreach ($entity->getUnitStuffList() as $unitHasUnitStuff) {
                $em->remove($unitHasUnitStuff);
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->getArmyShowUrl($breed));
    }

    /**
     * Creates a form to delete a Unit entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', HiddenType::class)
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function getArmyShowUrl(Breed $breed, Unit $unit = null)
    {
        $url = $this->generateUrl(
                'admin_breed_unit',
                array(
                    'breed' => $breed->getSlug(),
                    'game' => $breed->getGame()->getCode()
                    )
                );

        if ($unit) {
            $url .= '#unit-' . $unit->getSlug();
        }

        return $url;
    }
}
