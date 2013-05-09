<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\UnitTypeType;

/**
 * UnitType controller.
 *
 * @Route("/admin/unittype")
 */
class UnitTypeController extends Controller
{
    /**
     * Creates a new UnitType entity.
     *
     * @Route("/", name="unittype_create")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:UnitType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new UnitType();
        $form = $this->createForm(new UnitTypeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('unittype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new UnitType entity.
     *
     * @Route("/new", name="unittype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new UnitType();
        $form   = $this->createForm(new UnitTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a UnitType entity.
     *
     * @Route("/{id}", name="unittype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnitType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UnitType entity.
     *
     * @Route("/{id}/edit", name="unittype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnitType entity.');
        }

        $editForm = $this->createForm(new UnitTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing UnitType entity.
     *
     * @Route("/{id}", name="unittype_update")
     * @Method("PUT")
     * @Template("SitiowebArmyCreatorBundle:UnitType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnitType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UnitTypeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('unittype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a UnitType entity.
     *
     * @Route("/{id}", name="unittype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UnitType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('unittype'));
    }

    /**
     * Creates a form to delete a UnitType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
