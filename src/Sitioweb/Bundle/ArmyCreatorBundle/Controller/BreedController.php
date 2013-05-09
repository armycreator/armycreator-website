<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\BreedType;

/**
 * Breed controller.
 *
 * @Route("/admin/breed")
 */
class BreedController extends Controller
{

    /**
     * Finds and displays a Breed entity.
     *
     * @Route("/{game}/{breed}/show", name="admin_breed_show")
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Template()
     */
    public function showAction(Game $game, Breed $breed)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$breed) {
            throw $this->createNotFoundException('Unable to find Breed entity.');
        }

        return array(
            'breed'      => $breed,
        );
    }

    /**
     * Displays a form to create a new Breed entity.
     *
     * @Route("/{game}/new", name="admin_breed_new")
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @Template()
     */
    public function newAction(Game $game)
    {
        $entity = new Breed();
        $entity->setGame($game);
        $form   = $this->createForm(new BreedType(), $entity);

        return array(
            'entity' => $entity,
            'game' => $game,
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
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_breed_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'game' => $entity->getGame(),
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Breed entity.
     *
     * @Route("/{breed}/edit", name="admin_breed_edit")
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Template()
     */
    public function editAction(Breed $breed)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$breed) {
            throw $this->createNotFoundException('Unable to find Breed entity.');
        }

        $editForm = $this->createForm(new BreedType(), $breed);

        return array(
            'entity'      => $breed,
            'edit_form'   => $editForm->createView(),
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

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_breed_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Lists all Breed entities.
     *
     * @Route("/{game}", name="admin_breed")
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @Template()
     */
    public function indexAction(Game $game)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SitiowebArmyCreatorBundle:Breed')
            ->findBy(
                array('game' => $game), array('name' => 'ASC')
            );

        return array(
            'game' => $game,
            'entities' => $entities,
        );
    }
}
