<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\BreedGroup;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\BreedGroupType;

/**
 * BreedGroup controller.
 *
 * @Route("/admin/breedgroup")
 */
class BreedGroupController extends Controller
{
    /**
     * Lists all BreedGroup entities.
     *
     * @Route("/", name="breedgroup")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SitiowebArmyCreatorBundle:BreedGroup')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a BreedGroup entity.
     *
     * @Route("/{id}/show", name="breedgroup_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:BreedGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BreedGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new BreedGroup entity.
     *
     * @Route("/new", name="breedgroup_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new BreedGroup();
        $form   = $this->createForm(new BreedGroupType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new BreedGroup entity.
     *
     * @Route("/create", name="breedgroup_create")
     * @Method("post")
     * @Template("SitiowebArmyCreatorBundle:BreedGroup:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new BreedGroup();
        $request = $this->getRequest();
        $form    = $this->createForm(new BreedGroupType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('breedgroup_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BreedGroup entity.
     *
     * @Route("/{id}/edit", name="breedgroup_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:BreedGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BreedGroup entity.');
        }

        $editForm = $this->createForm(new BreedGroupType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing BreedGroup entity.
     *
     * @Route("/{id}/update", name="breedgroup_update")
     * @Method("post")
     * @Template("SitiowebArmyCreatorBundle:BreedGroup:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:BreedGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BreedGroup entity.');
        }

        $editForm   = $this->createForm(new BreedGroupType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('breedgroup_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a BreedGroup entity.
     *
     * @Route("/{id}/delete", name="breedgroup_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:BreedGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BreedGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('breedgroup'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
