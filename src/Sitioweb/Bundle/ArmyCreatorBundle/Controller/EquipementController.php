<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Equipement;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\EquipementType;

/**
 * Equipement controller.
 *
 * @Route("/admin/{game}/{breed}/equipement")
 * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
 * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
 */
class EquipementController extends Controller
{
    /**
     * Creates a new Equipement entity.
     *
     * @Route("/", name="equipement_create")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:Equipement:new.html.twig")
     */
    public function createAction(Request $request, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $entity  = new Equipement();
        $form = $this->createForm(new EquipementType($breed), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $entity->setBreed($breed);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($form->get('createAndAdd')->isClicked()) {
                $url = $this->generateUrl(
                        'equipement_new',
                        [
                            'breed' => $breed->getSlug(),
                            'game' => $breed->getGame()->getCode(),
                        ]
                    );
                return $this->redirect($url);
            } else {
                return $this->redirect($this->getArmyShowUrl($breed));
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * quickCreateAction
     *
     * @access public
     * @return void
     *
     * @Route("/quick-create", name="equipement_quick_create")
     * @Method("POST")
     */
    public function quickCreateAction(Request $request, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('SitiowebArmyCreatorBundle:Equipement');

        $name = $request->request->get('name');

        $entity = $repo->findOneBy(['breed' => $breed, 'name' => $name]);
        $isNew = false;

        if (!$entity) {
            $entity = new Equipement;
            $entity->setBreed($breed)
                ->setName($name);
            $em->persist($entity);
            $em->flush();
            $isNew = true;
        }

        $response = new JsonResponse();
        $response->setData([ 'id' => $entity->getId(), 'isNew' => $isNew ]);
        return $response;
    }

    /**
     * Displays a form to create a new Equipement entity.
     *
     * @Route("/new", name="equipement_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $entity = new Equipement();
        $form   = $this->createForm(new EquipementType($breed), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Equipement entity.
     *
     * @Route("/{id}/edit", name="equipement_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Equipement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipement entity.');
        }

        $editForm = $this->createForm(new EquipementType($breed), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Equipement entity.
     *
     * @Route("/{id}", name="equipement_update")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:Equipement:edit.html.twig")
     */
    public function updateAction(Request $request, $id, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Equipement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EquipementType($breed), $entity);
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
     * Deletes a Equipement entity.
     *
     * @Route("/{id}/delete", name="equipement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:Equipement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Equipement entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->getArmyShowUrl($breed));
    }

    /**
     * Creates a form to delete a Equipement entity by id.
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

    /**
     * getArmyShowUrl
     *
     * @param Breed $breed
     * @access private
     * @return string
     */
    private function getArmyShowUrl(Breed $breed)
    {
        $url = $this->generateUrl(
                'admin_breed_stuff',
                array(
                    'breed' => $breed->getSlug(),
                    'game' => $breed->getGame()->getCode()
                    )
                );
        return $url;
    }
}
