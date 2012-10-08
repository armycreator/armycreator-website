<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\BreedType;

/**
 * Breed controller.
 *
 * @Route("/admin/breed")
 */
class BreedController extends Controller
{
    /**
     * Lists all Breed entities.
     *
     * @Route("/", name="admin_breed")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SitiowebArmyCreatorBundle:Breed')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Breed entity.
     *
     * @Route("/{id}/show", name="admin_breed_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Breed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Breed entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Breed entity.
     *
     * @Route("/new", name="admin_breed_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Breed();
        $form   = $this->createForm(new BreedType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Breed entity.
     *
     * @Route("/create", name="admin_breed_create")
     * @Method("post")
     * @Template("SitiowebArmyCreatorBundle:Breed:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Breed();
        $request = $this->getRequest();
        $form    = $this->createForm(new BreedType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_breed_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Breed entity.
     *
     * @Route("/{id}/edit", name="admin_breed_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Breed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Breed entity.');
        }

        $editForm = $this->createForm(new BreedType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Breed entity.
     *
     * @Route("/{id}/update", name="admin_breed_update")
     * @Method("post")
     * @Template("SitiowebArmyCreatorBundle:Breed:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Breed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Breed entity.');
        }

        $editForm   = $this->createForm(new BreedType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_breed_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Breed entity.
     *
     * @Route("/{id}/delete", name="admin_breed_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:Breed')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Breed entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_breed'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
