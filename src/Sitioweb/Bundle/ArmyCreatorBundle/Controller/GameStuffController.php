<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Weapon;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Equipement;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\WeaponType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\EquipementType;

/**
 * GameStuff controller.
 *
 * @Route("/admin/{game}")
 * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
 */
class GameStuffController extends Controller
{
    /**
     * Displays a form to create a new weapon entity.
     *
     * @Route("/weapon/new", name="game_weapon_new", defaults={ "type": "weapon" })
     * @Route("/equipement/new", name="game_equipement_new", defaults={ "type": "equipement" })
     * @Method("GET")
     * @Template("SitiowebArmyCreatorBundle:GameStuff:edit.html.twig")
     */
    public function newAction(Game $game, $type)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('ROLE_CONTRIB_ALL')) {
            throw new AccessDeniedException();
        }

        if ($type === 'equipement') {
            $entity = new Equipement();
            $type = new EquipementType($game);
            $route = 'game_equipement_create';
        } else {
            $entity = new Weapon();
            $type = new WeaponType($game);
            $route = 'game_weapon_create';
        }
        $form = $this->createForm(
            $type,
            $entity,
            [
                'action' => $this->generateUrl($route, ['game' => $game->getCode()]),
                'method' => 'post',
            ]
        );

        return array(
            'game' => $game,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Weapon entity.
     *
     * @Route("/weapon/new", name="game_weapon_create", defaults={ "type": "weapon" })
     * @Route("/equipement/new", name="game_equipement_create", defaults={ "type": "equipement" })
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:GameStuff:edit.html.twig")
     */
    public function createAction(Request $request, Game $game, $type)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('ROLE_CONTRIB_ALL')) {
            throw new AccessDeniedException();
        }

        if ($type === 'weapon') {
            $entity  = new Weapon();
            $form = $this->createForm(new WeaponType($game), $entity);
            $route = 'game_weapon_new';
        } else {
            $entity  = new Equipement();
            $form = $this->createForm(new EquipementType($game), $entity);
            $route = 'game_equipement_new';
        }
        $form->bind($request);

        if ($form->isValid()) {
            $entity->setGame($game);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($form->get('createAndAdd')->isClicked()) {
                $url = $this->generateUrl($route, ['game' => $game->getCode()]);
                return $this->redirect($url);
            } else {
                return $this->redirect($this->getGameShowUrl($game));
            }
        }

        return array(
            'game' => $game,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Stuff entity.
     *
     * @ParamConverter("stuff", class="SitiowebArmyCreatorBundle:Stuff")
     * @Route("/weapon/{id}", name="game_weapon_edit", defaults={ "type": "weapon" })
     * @Route("/equipement/{id}", name="game_equipement_edit", defaults={ "type": "equipement" })
     * @Method("GET")
     * @Template()
     */
    public function editAction(Stuff $stuff, Game $game, $type)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('ROLE_CONTRIB_ALL')) {
            throw new AccessDeniedException();
        }

        $route = 'game_stuff_update';
        if ($stuff->getStuffType() == 'weapon') {
            $type = new WeaponType($game);
        } else {
            $type = new EquipementType($game);
        }

        $editForm = $this->createForm(
            $type,
            $stuff,
            [
                'action' => $this->generateUrl($route, ['game' => $game->getCode(), 'id' => $stuff->getId()]),
                'method' => 'post',
            ]
        );
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'game'      => $game,
            'entity'    => $stuff,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Stuff entity.
     *
     * @ParamConverter("stuff", class="SitiowebArmyCreatorBundle:Stuff")
     * @Route("/stuff/{id}", name="game_stuff_update")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:GameStuff:edit.html.twig")
     */
    public function updateAction(Request $request, Stuff $stuff, Game $game)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('ROLE_CONTRIB_ALL')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new WeaponType($game), $stuff);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            // dirty fix because description object are compared by reference, not by value
            // @see http://doctrine-orm.readthedocs.org/en/latest/reference/basic-mapping.html
            $edesc = $stuff->getDescription();
            if (is_object($edesc)) {
                $stuff->setDescription(clone $edesc);
            }
            $em->persist($stuff);
            $em->flush();

            return $this->redirect($this->getGameShowUrl($game));
        }

        return array(
            'entity'      => $stuff,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Stuff entity.
     *
     * @ParamConverter("stuff", class="SitiowebArmyCreatorBundle:Stuff")
     * @Route("/stuff/{id}", name="game_stuff_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Stuff $stuff, Game $game)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('ROLE_CONTRIB_ALL')) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($stuff->getId());
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stuff);
            $em->flush();
        }

        return $this->redirect($this->getGameShowUrl($game));
    }

    /**
     * Creates a form to delete a Stuff entity by id.
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
     * getGameShowUrl
     *
     * @param Game $game
     * @access private
     * @return string
     */
    private function getGameShowUrl(Game $game)
    {
        $url = $this->generateUrl(
                'admin_game_stuff',
                array(
                    'game' => $game->getCode()
                    )
                );
        return $url;
    }
}
