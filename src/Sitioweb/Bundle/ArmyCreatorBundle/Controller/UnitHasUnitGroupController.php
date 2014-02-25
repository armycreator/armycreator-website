<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\UnitHasUnitGroupType;

/**
 * UnitHasUnitGroup controller.
 *
 * @Route("/admin/{game}/{breed}/unithasunitgroup")
 * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
 * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
 */
class UnitHasUnitGroupController extends Controller
{
    /**
     * Creates a new UnitHasUnitGroup entity.
     *
     * @Route("/", name="unithasunitgroup_create")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:UnitHasUnitGroup:new.html.twig")
     */
    public function createAction(Request $request, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $entity  = new UnitHasUnitGroup();
        $form = $this->createForm(new UnitHasUnitGroupType($breed), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->getArmyShowUrl($breed));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new UnitHasUnitGroup entity.
     *
     * @Route("/new", name="unithasunitgroup_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $entity = new UnitHasUnitGroup();
        if ($request->query->has('group')) {
            $em = $this->getDoctrine()->getManager();
            $group = $em->getRepository('SitiowebArmyCreatorBundle:UnitGroup')->findOneBy(
                array(
                    'breed' => $breed,
                    'slug' => $request->query->get('group')
                )
            );
            $entity->setGroup($group);
        }

        $form   = $this->createForm(new UnitHasUnitGroupType($breed), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UnitHasUnitGroup entity.
     *
     * @Route("/{id}/edit", name="unithasunitgroup_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitHasUnitGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnitHasUnitGroup entity.');
        }

        $editForm = $this->createForm(new UnitHasUnitGroupType($breed), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing UnitHasUnitGroup entity.
     *
     * @Route("/{id}/update", name="unithasunitgroup_update")
     * @Template("SitiowebArmyCreatorBundle:UnitHasUnitGroup:edit.html.twig")
     */
    public function updateAction(Breed $breed, Request $request, $id)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitHasUnitGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnitHasUnitGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UnitHasUnitGroupType($breed), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->getArmyShowUrl($breed));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a UnitHasUnitGroup entity.
     *
     * @Route("/{id}/delete", name="unithasunitgroup_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitHasUnitGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UnitHasUnitGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('unithasunitgroup'));
    }

    /**
     * Creates a form to delete a UnitHasUnitGroup entity by id.
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

    private function getArmyShowUrl(Breed $breed)
    {
        $url = $this->generateUrl(
                'admin_breed_show',
                array(
                    'breed' => $breed->getSlug(),
                    'game' => $breed->getGame()->getCode()
                    )
                );
        return $url;
    }
}
