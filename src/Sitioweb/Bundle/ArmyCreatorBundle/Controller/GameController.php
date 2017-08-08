<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\GameType;

/**
 * Game controller.
 *
 * @Breadcrumb("breadcrumb.home", route="homepage")
 * @Breadcrumb("breadcrumb.admin.index", route="admin_game")
 */
class GameController extends Controller
{
    /**
     * Lists all Game entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SitiowebArmyCreatorBundle:Game')->findAll();

        $gameList = [];
        foreach ($entities as $game) {
            if ($this->get('oneup_acl.manager')->isGranted('VIEW', $game)) {
                $gameList[] = $game;
            }
        }

        $oi = new ObjectIdentity('class', 'Sitioweb\\Bundle\\ArmyCreatorBundle\\Entity\\Game');
        $canEditAll = $this->get('security.context')->isGranted('EDIT', $oi);

        return array(
            'entities' => $gameList,
            'canEditAll' => $canEditAll
        );
    }

    /**
     * gameStuffAction
     *
     * @param Game $game
     * @access public
     *
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @Template()
     */
    public function stuffAction(Game $game)
    {
        $stuffList = $this->get('doctrine.orm.default_entity_manager')
                        ->getRepository('SitiowebArmyCreatorBundle:Stuff')
                        ->findBy(['game' => $game], ['name' => 'asc']);

        return [
            'game' => $game,
            'stuffList' => $stuffList,
        ];
    }

    /**
     * Displays a form to create a new Game entity.
     *
     * @Breadcrumb("breadcrumb.admin.game.new", route="admin_game_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Game();
        $oi = new ObjectIdentity('class', 'Sitioweb\\Bundle\\ArmyCreatorBundle\\Entity\\Game');
        if (!$this->get('security.context')->isGranted('CREATE', $oi)) {
            throw new AccessDeniedException();
        }

        $form   = $this->createForm(new GameType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Game entity.
     *
     * @Template("SitiowebArmyCreatorBundle:Game:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $oi = new ObjectIdentity('class', 'Sitioweb\\Bundle\\ArmyCreatorBundle\\Entity\\Game');
        if (!$this->get('security.context')->isGranted('CREATE', $oi)) {
            throw new AccessDeniedException();
        }

        $entity  = new Game();
        $form    = $this->createForm(new GameType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_breed', array('game' => $entity->getCode())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Game entity.
     *
     * @Breadcrumb("{game.name}", route={"name"="admin_game_edit", "parameters"={"game" = "game.code"}})
     * @Template()
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @SecureParam(name="game", permissions="EDIT")
     */
    public function editAction(Game $game)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(new GameType(), $game);
        $deleteForm = $this->createDeleteForm($game->getId());

        return array(
            'entity'      => $game,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Game entity.
     *
     * @Template("SitiowebArmyCreatorBundle:Game:edit.html.twig")
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"code" = "code"}})
     * @SecureParam(name="game", permissions="EDIT")
     */
    public function updateAction(Request $request, Game $game)
    {
        $em = $this->getDoctrine()->getManager();

        $id = $game->getId();

        $editForm   = $this->createForm(new GameType(), $game);
        $deleteForm = $this->createDeleteForm($id);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($game);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('admin_game')
            );
        }

        return array(
            'entity'      => $game,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Game entity.
     *
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"code" = "code"}})
     */
    public function deleteAction(Request $request, Game $game)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('DELETE', $game)) {
            throw new AccessDeniedException();
        }

        $id = $game->getId();

        $form = $this->createDeleteForm($id);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($game);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_game'));
    }

    /**
     * createDeleteForm
     *
     * @param int $id
     * @access private
     * @return Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

}
