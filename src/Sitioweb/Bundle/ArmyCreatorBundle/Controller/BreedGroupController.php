<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\BreedGroup;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\BreedGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * BreedGroup controller.
 *
 * @Route("/admin/{game}/breedgroup")
 */
class BreedGroupController extends Controller
{
    /**
     * Lists all BreedGroup entities.
     *
     * @Route("/", name="breedgroup")
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @Template()
     */
    public function indexAction(Game $game)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SitiowebArmyCreatorBundle:BreedGroup')
            ->findByGame($game);

        return array(
            'game' => $game,
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new BreedGroup entity.
     *
     * @Route("/new", name="breedgroup_new")
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @Template()
     */
    public function newAction(Game $game)
    {
        $entity = new BreedGroup();
        $entity->setGame($game);
        $form   = $this->createForm(new BreedGroupType(), $entity);

        return array(
            'game' => $game,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new BreedGroup entity.
     *
     * @Route("/create", name="breedgroup_create")
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @Method("post")
     * @Template("SitiowebArmyCreatorBundle:BreedGroup:new.html.twig")
     */
    public function createAction(Request $request, Game $game)
    {
        $entity  = new BreedGroup();
        $form    = $this->createForm(new BreedGroupType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('breedgroup', array('game' => $entity->getGame()->getCode())));
        }

        return array(
            'entity' => $entity,
            'game' => $game,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BreedGroup entity.
     *
     * @Route("/{id}/edit", name="breedgroup_edit")
     * @ParamConverter("breedGroup", class="SitiowebArmyCreatorBundle:BreedGroup")
     * @Template()
     */
    public function editAction(BreedGroup $breedGroup)
    {
        $editForm = $this->createForm(new BreedGroupType(), $breedGroup);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $breedGroup,
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
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:BreedGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BreedGroup entity.');
        }

        $editForm   = $this->createForm(new BreedGroupType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'breedgroup',
                    array('game' => $entity->getGame()->getCode())
                )
            );
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
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @Method("post")
     */
    public function deleteAction(Request $request, $id, Game $game)
    {
        $form = $this->createDeleteForm($id);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:BreedGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BreedGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('breedgroup', ['game' => $game->getCode()]));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
