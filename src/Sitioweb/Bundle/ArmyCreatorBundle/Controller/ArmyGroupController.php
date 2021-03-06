<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\ArmyGroup;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\ArmyGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;

/**
 * ArmyGroup controller.
 *
 * @Route("/army/group")
 */
class ArmyGroupController extends Controller
{

    /**
     * Finds and displays a ArmyGroup entity.
     *
     * @Route("/{id}/show", name="army_group_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:ArmyGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArmyGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new ArmyGroup entity.
     *
     * @Route("/new", name="army_group_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ArmyGroup();
        $form   = $this->createForm(ArmyGroupType::class, $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new ArmyGroup entity.
     *
     * @Route("/create", name="army_group_create")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:ArmyGroup:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new ArmyGroup();
        $entity->setUser($this->get('user_service')->getArmyCreatorUser());
        $form = $this->createForm(ArmyGroupType::class, $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('army_group_list', array('groupId' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ArmyGroup entity.
     *
     * @Route("/{id}/edit", name="army_group_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:ArmyGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArmyGroup entity.');
        }

        $editForm = $this->createForm(ArmyGroupType::class, $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ArmyGroup entity.
     *
     * @Route("/{id}/update", name="army_group_update")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:ArmyGroup:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:ArmyGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArmyGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(ArmyGroupType::class, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('army_group_list', array('groupId' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ArmyGroup entity.
     *
     * @Route("/{id}/delete", name="army_group_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:ArmyGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ArmyGroup entity.');
            }


            $armyList = $entity->getArmyList();
            foreach ($armyList as  $army) {
                $army->setArmyGroup(null);
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('army_list'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', HiddenType::class)
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
