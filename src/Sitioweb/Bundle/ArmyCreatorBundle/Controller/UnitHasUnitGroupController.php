<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\UnitHasUnitGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
        $form = $this->createForm(UnitHasUnitGroupType::class, $entity, ['breed' => $breed]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->getArmyShowUrl($breed, $entity));
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

        $form   = $this->createForm(UnitHasUnitGroupType::class, $entity, ['breed' => $breed]);

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

        $editForm = $this->createForm(UnitHasUnitGroupType::class, $entity, ['breed' => $breed]);
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
        $editForm = $this->createForm(UnitHasUnitGroupType::class, $entity, ['breed' => $breed]);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->getArmyShowUrl($breed, $entity));
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
    public function deleteAction(Request $request,Breed $breed,  $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitHasUnitGroup')->find($id);
        $unitGroup = $entity->getGroup();

        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UnitHasUnitGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $url = $this->generateUrl(
            'admin_breed_unitgroup',
            ['game' => $breed->getGame()->getCode(), 'breed' => $breed->getSlug()]
        ) . '#unitGroup-' . $unitGroup->getSlug();

        return $this->redirect($url);
    }

    /**
     * moveAction
     *
     * @access public
     * @return Response
     *
     * @ParamConverter("unitHasUnitGroup", class="SitiowebArmyCreatorBundle:UnitHasUnitGroup")
     * @Route("/{id}/move_{direction}", name="unithasunitgroup_move")
     * @Template()
     */
    public function moveAction(UnitHasUnitGroup $unitHasUnitGroup, Breed $breed, Request $request, $direction)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $position = $request->query->get('position');

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        if ($direction == 'up') {
            $posExpr = $qb->expr()->gte('uhug.position', ':position');
        } else {
            $posExpr = $qb->expr()->lte('uhug.position', ':position');
        }

        $qb->select('uhug')
            ->from('SitiowebArmyCreatorBundle:UnitHasUnitGroup', 'uhug')
            ->where('uhug.group = :unitGroup')
            ->andWhere(
                $qb->expr()->orx(
                    $qb->expr()->isNull('uhug.position'),
                    $posExpr
                )
            )
            ->andWhere('uhug != :uhug')
            ->orderBy('uhug.position', ($direction == 'up' ? 'ASC' : 'DESC'))
            ->setParameters(
                [
                    'unitGroup' => $unitHasUnitGroup->getGroup(),
                        'position' => $position,
                        'uhug' => $unitHasUnitGroup,
                    ]
                );

        $entityList = $qb->getQuery()->getResult();

        $unitHasUnitGroup->setPosition($position);
        foreach($entityList as $entity) {
            if ($direction == 'up') {
                ++$position;
            } else {
                --$position;
            }
            $entity->setPosition($position);
        }

        $em->flush();

        $url = $this->generateUrl(
            'admin_breed_unitgroup',
            ['game' => $breed->getGame()->getCode(), 'breed' => $breed->getSlug()]
        ) . '#unitGroup-' . $unitHasUnitGroup->getGroup()->getSlug();
        return $this->redirect($url);
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
            ->add('id', HiddenType::class)
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    private function getArmyShowUrl(Breed $breed, UnitHasUnitGroup $uhug = null)
    {
        $url = $this->generateUrl(
            'admin_breed_unitgroup',
            array(
                'breed' => $breed->getSlug(),
                'game' => $breed->getGame()->getCode()
            )
        );

        if ($uhug) {
            $url .= '#unitGroup-' . $uhug->getGroup()->getSlug();
        }

        return $url;
    }
}
