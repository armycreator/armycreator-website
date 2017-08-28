<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Donation;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\DonationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Admin donation controller.
 *
 * @Route("/admin/various/donation")
 */
class AdminDonationController extends Controller
{

    /**
     * Lists all Donation entities.
     *
     * @Route("/", name="admin_donation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SitiowebArmyCreatorBundle:Donation')
            ->findBy([], ['createdAt' => 'DESC']);

        $totalByYear = [];
        foreach ($entities as $donation) {
            $year = $donation->getYear();
            if (!isset($totalByYear[$year])) {
                $totalByYear[$year] = 0;
            }
            $totalByYear[$year] += $donation->getAmount();
        }

        return array(
            'entities' => $entities,
            'totalByYear' => $totalByYear,
        );
    }
    /**
     * Creates a new Donation entity.
     *
     * @Route("/", name="admin_donation_create")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:Donation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Donation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_donation'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Donation entity.
     *
     * @param Donation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Donation $entity)
    {
        $form = $this->createForm(DonationType::class, $entity, array(
            'action' => $this->generateUrl('admin_donation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create', 'attr' => ['class' => 'acButton acButtonBig']));

        return $form;
    }

    /**
     * Displays a form to create a new Donation entity.
     *
     * @Route("/new", name="admin_donation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Donation();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Donation entity.
     *
     * @Route("/{id}/edit", name="admin_donation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Donation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Donation entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Donation entity.
    *
    * @param Donation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Donation $entity)
    {
        $form = $this->createForm(DonationType::class, $entity, array(
            'action' => $this->generateUrl('admin_donation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update', 'attr' => ['class' => 'acButton acButtonBig']));

        return $form;
    }

    /**
     * Edits an existing Donation entity.
     *
     * @Route("/{id}", name="admin_donation_update")
     * @Method("PUT")
     * @Template("SitiowebArmyCreatorBundle:Donation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Donation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Donation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_donation'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Donation entity.
     *
     * @Route("/{id}", name="admin_donation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:Donation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Donation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_donation'));
    }

    /**
     * Creates a form to delete a Donation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_donation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete', 'attr' => ['class' => 'acButton acButtonBig']))
            ->getForm()
        ;
    }
}
