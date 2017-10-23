<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\GameType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

        $canEditAll = $this->get('security.authorization_checker')->isGranted('ROLE_CONTRIB_ALL');

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
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_CONTRIB_ALL')) {
            throw new AccessDeniedException();
        }

        $entity = new Game();
        $form   = $this->createForm(GameType::class, $entity);

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
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_CONTRIB_ALL')) {
            throw new AccessDeniedException();
        }

        $entity  = new Game();
        $form    = $this->createForm(GameType::class, $entity);
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

        $editForm = $this->createForm(GameType::class, $game);
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

        $editForm   = $this->createForm(GameType::class, $game);
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
            ->add('id', HiddenType::class)
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
