<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\GameType;

/**
 * Game controller.
 *
 * @Route("/admin/game")
 */
class GameController extends Controller
{
    /**
     * Lists all Game entities.
     *
     * @Route("/", name="admin_game")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SitiowebArmyCreatorBundle:Game')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Game entity.
     *
     * @Route("/{id}/show", name="admin_game_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Game')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Game entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Game entity.
     *
     * @Route("/new", name="admin_game_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Game();
        $form   = $this->createForm(new GameType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Game entity.
     *
     * @Route("/create", name="admin_game_create")
     * @Method("post")
     * @Template("SitiowebArmyCreatorBundle:Game:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Game();
        $request = $this->getRequest();
        $form    = $this->createForm(new GameType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_game_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Game entity.
     *
     * @Route("/{id}/edit", name="admin_game_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Game')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Game entity.');
        }

        $editForm = $this->createForm(new GameType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Game entity.
     *
     * @Route("/{id}/update", name="admin_game_update")
     * @Method("post")
     * @Template("SitiowebArmyCreatorBundle:Game:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Game')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Game entity.');
        }

        $editForm   = $this->createForm(new GameType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_game_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Game entity.
     *
     * @Route("/{id}/delete", name="admin_game_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:Game')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Game entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_game'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
