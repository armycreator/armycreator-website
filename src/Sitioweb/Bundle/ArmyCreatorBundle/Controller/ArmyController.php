<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\ArmyType;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army;

/**
 * ArmyController
 * 
 * @uses BaseController
 * @Route("/army")
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
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
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
        } else {
            $group = null;
            $deleteGroupForm = null;
            $armyList = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:Army')->findByUser($this->getUser());
        }

        // getting armyList
        $deleteArmyList = array();
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
     */
    public function detailAction($slug)
    {
        // getting army
        $army = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($slug);
        if ($army === null) {
            throw new NotFoundHttpException('Army not found');
        }

        // get unit type list
        $unitTypeList = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:UnitType')->findByBreed($army->getBreed());

        return array(
            'army' => $army,
            'unitTypeList' => $unitTypeList
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
     */
    public function createAction()
    {
        $entity  = new Army();
        $request = $this->getRequest();
        $form    = $this->createForm(new ArmyType($this->getUser()), $entity);
        $form->bindRequest($request);

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
     * Deletes a Army entity.
     *
     * @Route("/{id}/delete", name="army_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:Army')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Army entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('army_list'));
    }

}

