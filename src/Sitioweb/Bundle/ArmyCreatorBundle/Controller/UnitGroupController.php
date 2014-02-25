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
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\UnitGroupType;

/**
 * UnitGroup controller.
 *
 * @Route("/admin/{game}/{breed}/unitgroup")
 * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
 * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
 */
class UnitGroupController extends Controller
{
    /**
     * Creates a new UnitGroup entity.
     *
     * @Route("/create", name="unitgroup_create")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:UnitGroup:new.html.twig")
     */
    public function createAction(Request $request, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $entity  = new UnitGroup();
        $form = $this->createForm(new UnitGroupType($breed), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setBreed($breed);
            $em->persist($entity);
            $em->flush();

            $url = $this->generateUrl(
                'admin_breed_show',
                array(
                    'breed' => $breed->getSlug(),
                    'game' => $breed->getGame()->getCode()
                )
            );
            return $this->redirect($url);
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new UnitGroup entity.
     *
     * @Route("/new/{unitTypeSlug}", name="unitgroup_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Breed $breed, $unitTypeSlug)
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

        $entity = new UnitGroup();
        $entity->setUnitType($unitType);
        $entity->setBreed($breed);
        $form   = $this->createForm(new UnitGroupType($breed), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UnitGroup entity.
     *
     * @Route("/{unitGroupSlug}/edit", name="unitgroup_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($unitGroupSlug, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->get('doctrine')->getManager();
        $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitGroup')->findOneBy(
            array(
                'breed' => $breed,
                'slug' => $unitGroupSlug
            )
        );

        $editForm = $this->createForm(new UnitGroupType($breed), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing UnitGroup entity.
     *
     * @Route("/{id}", name="unitgroup_update")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:UnitGroup:edit.html.twig")
     */
    public function updateAction(Request $request, Breed $breed, $id)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnitGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UnitGroupType($breed), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $entity->setBreed($breed);
            $em->persist($entity);
            $em->flush();

            $url = $this->generateUrl(
                'admin_breed_show',
                array(
                    'breed' => $breed->getSlug(),
                    'game' => $breed->getGame()->getCode()
                )
            );
            return $this->redirect($url);
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a UnitGroup entity.
     *
     * @Route("/{id}/delete", name="unitgroup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Breed $breed, $id)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UnitGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $url = $this->generateUrl(
            'admin_breed_show',
            array(
                'breed' => $breed->getSlug(),
                'game' => $breed->getGame()->getCode()
            )
        );
        return $this->redirect($url);
    }

    /**
     * Creates a form to delete a UnitGroup entity by id.
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
