<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Weapon;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\WeaponType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Weapon controller.
 *
 * @Route("/admin/{game}/{breed}/weapon")
 * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
 * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
 */
class WeaponController extends Controller
{
    /**
     * Creates a new Weapon entity.
     *
     * @Route("/", name="weapon_create")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:Weapon:new.html.twig")
     */
    public function createAction(Request $request, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $entity  = new Weapon();
        $form = $this->createForm(WeaponType::class, $entity, ['game' => $breed->getGame()]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setBreed($breed);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($form->get('createAndAdd')->isClicked()) {
                $url = $this->generateUrl(
                        'weapon_new',
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
     * @Route("/quick-create", name="weapon_quick_create")
     * @Method("POST")
     */
    public function quickCreateAction(Request $request, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('SitiowebArmyCreatorBundle:Weapon');

        $name = $request->request->get('name');

        $entity = $repo->findOneBy(['breed' => $breed, 'name' => $name]);
        $isNew = false;

        if (!$entity) {
            $entity = new Weapon;
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
     * Displays a form to create a new Weapon entity.
     *
     * @Route("/new", name="weapon_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $entity = new Weapon();
        $form   = $this->createForm(WeaponType::class, $entity, ['game' => $breed->getGame()]);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Weapon entity.
     *
     * @Route("/{id}/edit", name="weapon_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Weapon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Weapon entity.');
        }

        $editForm = $this->createForm(WeaponType::class, $entity, ['game' => $breed->getGame()]);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'weapon'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Weapon entity.
     *
     * @Route("/{id}/update", name="weapon_update")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:Weapon:edit.html.twig")
     */
    public function updateAction(Request $request, $id, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Weapon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Weapon entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(WeaponType::class, $entity, ['game' => $breed->getGame()]);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            // dirty fix because description object are compared by reference, not by value
            // @see http://doctrine-orm.readthedocs.org/en/latest/reference/basic-mapping.html
            $edesc = $entity->getDescription();
            if (is_object($edesc)) {
                $entity->setDescription(clone $edesc);
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->getArmyShowUrl($breed));
        }

        return array(
            'weapon'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Weapon entity.
     *
     * @Route("/{id}/delete", name="weapon_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:Weapon')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Weapon entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->getArmyShowUrl($breed));
    }

    /**
     * Creates a form to delete a Weapon entity by id.
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
