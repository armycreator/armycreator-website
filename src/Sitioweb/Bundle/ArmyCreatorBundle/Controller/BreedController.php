<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\BreedType;

/**
 * Breed controller.
 *
 * @Breadcrumb("breadcrumb.home", route="homepage")
 * @Breadcrumb("breadcrumb.admin.index", route="admin_game")
 */
class BreedController extends Controller
{
    /**
     * Finds and displays a Breed entity.
     *
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Template()
     */
    public function showAction(Game $game, Breed $breed)
    {
        $params = [ 'breed' => $breed->getSlug(), 'game' => $breed->getGame()->getCode() ];
        if ($breed->getUnitTypeList()->isEmpty()) {
            $url = $this->generateUrl('admin_breed_unittype', $params);
        } else {
            $url = $this->generateUrl('admin_breed_unitgroup', $params);
        }

        $this->addBreadcrumb($game, $breed);

        return $this->redirect($url);
    }

    /**
     * Finds and displays a Breed entity.
     *
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Template()
     */
    public function unitGroupAction(Game $game, Breed $breed)
    {
        $unitTypeList = $breed->getUnitTypeList();

        $deleteUgFormList = [];
        foreach ($unitTypeList as $unitType) {
            $unitGroupList = $unitType->getUnitGroupList();
            foreach ($unitGroupList as $unitGroup) {
                $unitGroupUsed = $this->get('doctrine')
                    ->getRepository('SitiowebArmyCreatorBundle:Squad')
                    ->findOneByUnitGroup($unitGroup);

                if (!$unitGroupUsed) {
                    $deleteUgFormList[$unitGroup->getId()] = $this->createDeleteForm($unitGroup->getId());
                }
            }
        }

        $this->addBreadcrumb($game, $breed);

        return array(
            'breed' => $breed,
            'deleteUgFormList' => $deleteUgFormList,
        );
    }

    /**
     * Finds and displays a Breed entity.
     *
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Template()
     */
    public function unitAction(Game $game, Breed $breed)
    {
        $unitList = $this->get('doctrine')
                        ->getRepository('SitiowebArmyCreatorBundle:Unit')
                        ->findBy(['breed' => $breed], ['name' => 'asc']);

        $deleteUnitFormList = [];
        foreach ($unitList as $unit) {
            $unitUsed = $this->get('doctrine')
                ->getRepository('SitiowebArmyCreatorBundle:SquadLine')
                ->findOneByUnit($unit);
            if (!$unitUsed) {
                $deleteUnitFormList[$unit->getId()] = $this->createDeleteForm($unit->getId());
            }
        }

        $this->addBreadcrumb($game, $breed);

        return array(
            'breed' => $breed,
            'unitList' => $unitList,
            'deleteUnitFormList' => $deleteUnitFormList,
        );
    }

    /**
     * unitTypeAction
     *
     * @param Breed $breed
     * @access public
     * @return void
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Template()
     */
    public function unitTypeAction(Game $game, Breed $breed)
    {
        $this->addBreadcrumb($game, $breed);

        return array('breed' => $breed);
    }

    /**
     * Finds and displays a Breed entity.
     *
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Template()
     */
    public function stuffAction(Game $game, Breed $breed)
    {
        $weaponList = $this->get('doctrine')
                        ->getRepository('SitiowebArmyCreatorBundle:Weapon')
                        ->findBy(['breed' => $breed], ['name' => 'asc']);

        $equipementList = $this->get('doctrine')
                        ->getRepository('SitiowebArmyCreatorBundle:Equipement')
                        ->findBy(['breed' => $breed], ['name' => 'asc']);

        $weaponDeleteList = [];
        foreach ($weaponList as $weapon) {
            $weaponDeleteList[$weapon->getId()] = $this->createDeleteForm($weapon->getId());
        }

        $equipementDeleteList = [];
        foreach ($equipementList as $equipement) {
            $equipementDeleteList[$equipement->getId()] = $this->createDeleteForm($equipement->getId());
        }

        $this->addBreadcrumb($game, $breed);

        return array(
            'breed' => $breed,
            'weaponList' => $weaponList,
            'equipementList' => $equipementList,
            'deleteWeaponFormList' => $weaponDeleteList,
            'deleteEquipementFormList' => $equipementDeleteList,
        );
    }

    /**
     * Displays a form to create a new Breed entity.
     *
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @Template()
     */
    public function newAction(Game $game)
    {
        $oi = new ObjectIdentity('class', 'Sitioweb\\Bundle\\ArmyCreatorBundle\\Entity\\Breed');
        if (!$this->get('security.context')->isGranted('EDIT', $oi)) {
            throw new AccessDeniedException();
        }

        $entity = new Breed();
        $entity->setGame($game);
        $form   = $this->createForm(new BreedType($game), $entity);

        $this->addBreadcrumb($game);
        $this->get("apy_breadcrumb_trail")->add('breadcrumb.admin.breed.new');

        return array(
            'entity' => $entity,
            'game' => $game,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Breed entity.
     *
     * @Template("SitiowebArmyCreatorBundle:Breed:new.html.twig")
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     */
    public function createAction(Request $request, Game $game)
    {
        $oi = new ObjectIdentity('class', 'Sitioweb\\Bundle\\ArmyCreatorBundle\\Entity\\Breed');
        if (!$this->get('security.context')->isGranted('CREATE', $oi)) {
            throw new AccessDeniedException();
        }

        $entity  = new Breed();
        $form    = $this->createForm(new BreedType($game), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setGame($game);
            $em->persist($entity);
            $em->flush();

            $url = $this->generateUrl(
                'admin_breed_show',
                ['game' => $game->getCode(), 'breed' => $entity->getSlug()]
            );
            return $this->redirect($url);
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
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Template()
     */
    public function editAction(Game $game, Breed $breed)
    {
        $this->checkPermission($breed);

        $editForm = $this->createForm(new BreedType($breed->getGame()), $breed);

        $this->addBreadcrumb($game, $breed);

        $deleteForm = $this->createDeleteForm($game->getId());

        return array(
            'game' => $game,
            'entity'      => $breed,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Breed entity.
     *
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Template("SitiowebArmyCreatorBundle:Breed:edit.html.twig")
     */
    public function updateAction(Breed $breed)
    {
        $this->checkPermission($breed);

        $em = $this->getDoctrine()->getManager();

        if (!$breed) {
            throw $this->createNotFoundException('Unable to find Breed entity.');
        }

        $editForm   = $this->createForm(new BreedType($breed->getGame()), $breed);

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($breed);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_breed', array('game' => $breed->getGame()->getCode())));
        }

        return array(
            'entity'      => $breed,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Lists all Breed entities.
     *
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @Template()
     */
    public function indexAction(Game $game)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('VIEW', $game)) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SitiowebArmyCreatorBundle:Breed')
            ->findBy(['game' => $game], ['name' => 'ASC']);

        $oi = new ObjectIdentity('class', 'Sitioweb\\Bundle\\ArmyCreatorBundle\\Entity\\Breed');
        $canEditAll = $this->get('security.context')->isGranted('CREATE', $oi);

        $this->addBreadcrumb($game);

        return array(
            'game' => $game,
            'entities' => $entities,
            'canEditAll' => $canEditAll
        );
    }

    /**
     * Deletes a Game entity.
     *
     * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     */
    public function deleteAction(Game $game, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('DELETE', $breed)) {
            throw new AccessDeniedException();
        }

        $id = $breed->getId();

        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($breed);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_breed', ['game' => $game->getCode()]));
    }

    /**
     * checkPermission
     *
     * @param Breed $breed
     * @param bool $permission
     * @access private
     * @return boolean
     */
    private function checkPermission(Breed $breed = null, $permission = 'EDIT')
    {
        $oi = new ObjectIdentity('class', 'Sitioweb\\Bundle\\ArmyCreatorBundle\\Entity\\Breed');
        $canEditAll = $this->get('security.context')->isGranted($permission, $oi);

        if ($canEditAll) {
            $canEditInstance = true;
        } elseif($breed) {
            $oi = ObjectIdentity::fromDomainObject($breed);
            $canEditInstance = $this->get('security.context')->isGranted($permission, $oi);
        } else {
            $canEditInstance = true;
        }

        if (!$canEditInstance) {
            throw new AccessDeniedException();
        }
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
     * addBreadcrumb
     *
     * @access private
     * @return void
     */
    private function addBreadcrumb(Game $game, Breed $breed = null)
    {
        // Breadcrumb
        $this->get("apy_breadcrumb_trail")->add(
            $game->getName(),
            'admin_breed',
            ['game' =>  $game->getCode()]
        );

        if ($breed) {
            $this->get("apy_breadcrumb_trail")->add(
                $breed->getName(),
                'admin_breed_show',
                ['game' =>  $game->getCode(), 'breed' => $breed->getSlug()]
            );
        }
    }
}
