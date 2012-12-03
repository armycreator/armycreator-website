<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation as Security;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\ArmyType;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army;

/**
 * ArmyController
 * 
 * @uses BaseController
 * @Route("/army")
 * @Security\PreAuthorize("isFullyAuthenticated()")
 * @Breadcrumb("Home", route="homepage")
 * @Breadcrumb("My army list", route="army_list")
 *
 * @author Julien Deniau <julien@sitioweb.fr> 
 */

class ArmyController extends Controller
{
    /**
     * listAction
     *
     * @access public
     * @return void
     *
     * @Route("/group/{groupId}", requirements={"groupId" = "\d+"}, name="army_group_list")
     * @Route("/", name="army_list", defaults={"groupId" = null})
     * @Template()
     */
    public function listAction($groupId)
    {
        if ($groupId > 0) {
            $group = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:ArmyGroup')->find((int) $groupId);
            $deleteGroupForm = $this->createDeleteForm($group->getId());
            
            $armyList = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:Army')->findBy(array(
                'user' => $this->getUser(),
                'armyGroup' => $group
            ));

            // Breadcrumb
            $this->get("apy_breadcrumb_trail")->add(
                $group->getName(),
                'army_group_list',
                array('groupId' =>  $group->getId())
            );
        } else {
            $group = null;
            $deleteGroupForm = null;
            $armyList = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:Army')->findByUser($this->getUser());
        }

        // getting armyList
        $deleteArmyListForm = array();
        foreach ($armyList as $army) {
            $deleteArmyListForm[$army->getId()] = $this->createDeleteForm($army->getId());
        }

        return array(
            'group' => $group,
            'armyList' => $armyList,
            'deleteArmyListForm' => $deleteArmyListForm,
            'deleteGroupForm' => $deleteGroupForm
        );
    }

    /**
     * detailAction
     *
     * @access public
     * @return void
     *
     * @Route("/{slug}", name="army_detail")
     * @Template()
     * @Security\PreAuthorize("isAnonymous() || isAuthenticated()")
     */
    public function detailAction($slug)
    {
        // getting army
        $army = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($slug);
        if ($army === null) {
            throw new NotFoundHttpException('Army not found');
        }

        // security
        if ($this->getUser() != $army->getUser() && !$army->getIsShared()) {
            throw new AccessDeniedException('Army not shared');
        }
        
        // Breadcrumb
        if ($army->getArmyGroup() !== null) {
            $this->get("apy_breadcrumb_trail")->add(
                $army->getArmyGroup()->getName(),
                'army_group_list',
                array('groupId' =>  $army->getArmyGroup()->getId())
            );
        }
        $this->get("apy_breadcrumb_trail")->add($army->getName(), 'army_detail', array('slug' =>  $army->getSlug()));

        // get unit type list
        $unitTypeList = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:UnitType')->findByBreed($army->getBreed());

        // delete form
        $deleteForm = $this->createDeleteForm($army->getId());

        $squadList = $army->getSquadList();
        foreach ($squadList as $squad) {
            $deleteSquadListForm[$squad->getId()] = $this->createDeleteForm($squad->getId());
        }

        return array(
            'army' => $army,
            'unitTypeList' => $unitTypeList,
            'deleteSquadListForm' => $deleteSquadListForm,
            'deleteForm' => $deleteForm->createView()
        );
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
     * Displays a form to create a new Army entity.
     *
     * @Route("/action/new", name="army_new")
     * @Template()
     * @Breadcrumb("New")
     */
    public function newAction()
    {
        $entity = new Army();
        $form   = $this->createForm(new ArmyType($this->getUser()), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Army entity.
     *
     * @Route("/action/create", name="army_create")
     * @Method("post")
     * @Template("SitiowebArmyCreatorBundle:Army:new.html.twig")
     * @Breadcrumb("New")
     */
    public function createAction()
    {
        $entity  = new Army();
        $request = $this->getRequest();
        $form    = $this->createForm(new ArmyType($this->getUser()), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity->setUser($this->getUser());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('army_detail', array('slug' => $entity->getSlug())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * editAction
     *
     * @access public
     * @return void
     *
     * @Route("/{slug}/edit", name="army_edit")
     * @Template()
     * @Breadcrumb("Edit")
     */
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Army entity.');
        }

        $editForm = $this->createForm(new ArmyType($this->getUser()), $entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Army entity.
     *
     * @Route("/{slug}/update", name="army_update")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:Army:edit.html.twig")
     * @Breadcrumb("Edit")
     */
    public function updateAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Army entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getId());
        $editForm = $this->createForm(new ArmyType($this->getUser()), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('army_detail', array('slug' => $entity->getSlug())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Army entity.
     *
     * @Route("/{slug}/delete", name="army_delete")
     * @Method("POST")
     * @Breadcrumb("Delete")
     */
    public function deleteAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Army entity.');
        }

        $form = $this->createDeleteForm($entity->getId());
        $form->bind($request);

        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('army_list'));
    }

}

