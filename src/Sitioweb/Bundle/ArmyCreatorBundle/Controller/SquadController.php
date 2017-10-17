<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use JMS\SecurityExtraBundle\Annotation as Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType;
use Sitioweb\Bundle\ArmyCreatorBundle\Event\GameEvent;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\BreedSelectType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\SquadType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * SquadController
 *
 * @uses Controller
 *
 * @Route("/army/{armySlug}/squad")
 * @Security\PreAuthorize("isFullyAuthenticated()")
 * @Breadcrumb("breadcrumb.home", route="homepage")
 * @Breadcrumb("breadcrumb.army_list", route="army_list")
 */
class SquadController extends Controller
{
    /**
     * selectBreedAction
     *
     * @access public
     * @return Response
     *
     * @Route("/new", name="squad_select_breed")
     * @Template()
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"armySlug" = "slug"}})
     */
    public function selectBreedAction(Army $army)
    {
        // breadcrumb
        $this->setArmyBreadCrumb($army);
        $tmp = $this->get('translator')
                    ->trans('breadcrumb.squad_new.select_breed');
        $this->get("apy_breadcrumb_trail")->add($tmp);

        // security
        if ($this->get('user_service')->getArmyCreatorUser() != $army->getUser()) {
            throw new AccessDeniedException();
        }

        //$em = $this->get('doctrine')->getManager();
        //$breedList = $em->getRepository('SitiowebArmyCreatorBundle:Breed')
        //    ->findBy([ 'available' => true, 'game' => $army->getBreed()->getGame() ]);

        return array(
            'army' => $army,
            'game' => $army->getBreed()->getGame(),
            'externalUser' => false
        );
    }

    /**
     * selectUnitTypeAction
     *
     * @param Army $army
     * @access public
     * @return Response
     *
     * @Route("/new/{breedSlug}", name="squad_select_unitType")
     * @Template()
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"armySlug" = "slug"}})
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breedSlug" = "slug"}})
     */
    public function selectUnitTypeAction(Army $army, Breed $breed)
    {
        $params = $this->selectBreedAction($army);

        return $params + ['breed' => $breed];
    }

    /**
     * Displays a form to create a new Squad entity.
     *
     * @Route("/new/{breedSlug}/{unitTypeSlug}", name="squad_new")
     * @Template()
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"armySlug" = "slug"}})
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breedSlug" = "slug"}})
     */
    public function newAction(Army $army, Breed $breed, $unitTypeSlug)
    {
        $em = $this->get('doctrine')->getManager();

        // getting unitType
        $unitType = $em->getRepository('SitiowebArmyCreatorBundle:UnitType')->findOneBy(
            array(
                'breed' => $breed,
                'slug' => $unitTypeSlug
            )
        );
        if ($unitType === null) {
            throw new NotFoundHttpException('Unit type not found');
        }

        // breadcrumb
        $this->setArmyBreadCrumb($army);
        $tmp = $this->get('translator')
                    ->trans('breadcrumb.squad_new.%unit_type%', array('unit_type' => $unitType->getName()));
        $this->get("apy_breadcrumb_trail")->add($tmp);

        // security
        if ($this->get('user_service')->getArmyCreatorUser() != $army->getUser()) {
            throw new AccessDeniedException();
        }

        $breedList = $em->getRepository('SitiowebArmyCreatorBundle:Breed')
            ->findBy([ 'available' => true, 'game' => $army->getBreed()->getGame() ]);

        return array(
            'army' => $army,
            'breed' => $breed,
            'breedList' => $breedList,
            'currentUnitType' => $unitType,
            'externalUser' => false
        );
    }

    /**
     * linkUnitAction
     *
     * @access public
     * @return void
     *
     * @Route("/link/{id}", name="squad_link_unit")
     * @Template()
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"armySlug" = "slug"}})
     * @ParamConverter(
     *     "squad",
     *     class="SitiowebArmyCreatorBundle:Squad",
     *     options={ "id" = "id" }
     * )
     */
    public function linkUnitAction(Army $army, Squad $squad, Request $request)
    {
        // security
        if ($this->get('user_service')->getArmyCreatorUser() != $army->getUser()) {
            throw new AccessDeniedException();
        }

        // select current breed
        $breed = null;
        if ($request->query->has('breed')) {
            $breed = $this->get('doctrine')
                ->getRepository('SitiowebArmyCreatorBundle:Breed')
                ->findOneBySlug($request->query->get('breed'));
        }

        if (!$breed) {
            $breed = $army->getBreed();
        }

        $action = $this->generateUrl('squad_link_unit', ['id' => $squad->getId(), 'armySlug' => $army->getSlug()]);
        $breedListType = $this->createForm(BreedSelectType::class, ['breed' => $breed], ['action' => $action]);

        if ($request->isMethod('post')) {
            $breedListType->handleRequest($request);
            if ($breedListType->isValid()) {
                $breed = $breedListType->getData()['breed'];
                $breedSlug = $breed->getSlug();

                $params = ['id' => $squad->getId(), 'armySlug' => $army->getSlug(), 'breed' => $breedSlug];
                return $this->redirect($this->generateUrl('squad_link_unit', $params));
            }
        }

        $this->setArmyBreadCrumb($army);
        $tmp = $this->get('translator')
                    ->trans('breadcrumb.squad_link');
        $this->get("apy_breadcrumb_trail")->add($tmp);

        return [
            'breedForm' => $breedListType->createView(),
            'army' => $army,
            'breed' => $breed,
            'squad' => $squad,
            'externalUser' => false
        ];
    }

    /**
     * duplicateAction
     *
     * @param Army $army
     * @param Squad $squad
     * @access public
     * @return void
     *
     * @Route("/duplicate/{id}", name="squad_duplicate")
     * @Template()
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"armySlug" = "slug"}})
     * @ParamConverter("squad", class="SitiowebArmyCreatorBundle:Squad", options={ "id" = "id" })
     */
    public function duplicateAction(Army $army, Squad $squad)
    {
        $em = $this->getDoctrine()->getManager();

        // squad
        $newSquad = clone $squad;
        $newSquad->setId(null);

        // squad line list
        $squadLineList = $squad->getSquadLineList();
        foreach ($squadLineList as $squadLine) {
            $tmpSquadLine = clone $squadLine;
            $tmpSquadLine->setId(null)
                ->setSquad($newSquad);
            $em->persist($tmpSquadLine);

            // squad line stuff list
            $squadLineStuffList = $squadLine->getSquadLineStuffList();
            foreach ($squadLineStuffList as $squadLineStuff) {
                $tmpSquadLineStuff = clone $squadLineStuff;
                $tmpSquadLineStuff->setId(null)
                    ->setSquadLine($tmpSquadLine);

                $em->persist($tmpSquadLineStuff);
            }
        }

        $em->persist($newSquad);
        $em->flush();

        return $this->redirect($this->generateUrl('army_detail', array('slug' => $army->getSlug())));
    }


    /**
     * createAction
     *
     * @param mixed $armySlug
     * @access public
     * @return void
     *
     * @Route("/create/{unitGroupId}", requirements={"id" = "\d+"}, name="squad_create")
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"armySlug" = "slug"}})
     * @Method("post")
     * @Template("SitiowebArmyCreatorBundle:SquadLine:new.html.twig")
     */
    public function createAction(Request $request, Army $army, $unitGroupId)
    {
        // getting unit group
        $unitGroup = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:UnitGroup')->find($unitGroupId);
        if ($unitGroup === null) {
            throw new NotFoundHttpException('Unit group not found');
        }

        $entity  = new Squad();
        $entity->mapUnitGroup($unitGroup, true);


        $form    = $this->createForm(SquadType::class, $entity, ['breed' => $unitGroup->getUnitType()->getBreed()]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->preUpdate();

            if (!$entity->getSquadLineList()->isEmpty()) {
                $entity->setArmy($army);
                $em->persist($entity);
            }
            $em->flush();

            // dispatch event
            $this->get('event_dispatcher')
                ->dispatch(
                    'armycreator.event.squad.new',
                    new GameEvent($army->getBreed()->getGame())
                );

            return $this->redirect($this->generateUrl('army_detail', array('slug' => $army->getSlug())));
        }

        return array(
            'entity' => $entity,
            'army' => $army,
            'breed' => $army->getBreed(),
            'currentUnitType' => $unitGroup->getUnitType(),
            'form' => $form->createView(),
        );
    }

    /**
     * editAction
     *
     * @access public
     * @return void
     *
     * @Route("/edit/{id}", name="squad_edit")
     * @Template()
     *
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"armySlug" = "slug"}})
     * @ParamConverter(
     *     "squad",
     *     class="SitiowebArmyCreatorBundle:Squad",
     *     options={ "id" = "id" }
     * )
     */
    public function editAction(Army $army, Squad $entity)
    {
        // breadcrumb
        $this->setArmyBreadCrumb($army);
        $tmp = $this->get('translator')
                    ->trans('breadcrumb.squad_edit.%squad_name%', array('squad_name' => $entity->getName()));
        $this->get("apy_breadcrumb_trail")->add($tmp);

        $entity->addEmptySquadLine(true);
        $editForm = $this->createForm(SquadType::class, $entity, ['breed' => $entity->getUnitType()->getBreed()]);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'breed'        => $army->getBreed(),
            'army'        => $army,
            'entity'      => $entity,
            'currentUnitType' => $entity->getUnitType(),
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'externalUser' => false
        );
    }

    /**
     * moveAction
     *
     * @access public
     * @return void
     *
     * @Route(
     *  "/move/{squadId}/{breedSlug}/{unitTypeSlug}",
     *  name="squad_move",
     *  options={"expose": true}
     * )
     * @ParamConverter(
     *     "squad",
     *     class="SitiowebArmyCreatorBundle:Squad",
     *     options={ "id" = "squadId" }
     * )
     * @ParamConverter(
     *     "breed",
     *     class="SitiowebArmyCreatorBundle:Breed",
     *     options={ "mapping": { "breedSlug": "slug" } }
     * )
     */
    public function moveAction(Request $request, Squad $squad, Breed $breed, $unitTypeSlug)
    {
        $army = $squad->getArmy();
        if ($this->get('user_service')->getArmyCreatorUser() != $army->getUser()) {
            throw new AccessDeniedException();
        }

         $em = $this->get('doctrine')->getManager();
        // get unittype
        $unitType = $em
            ->getRepository('SitiowebArmyCreatorBundle:UnitType')
            ->findOneBy(
                [
                    'breed' => $breed,
                    'slug' => $unitTypeSlug
                ]
            );

        if (!$unitType) {
            return $this->createNotFoundException('UnitType not found');
        }

         $squadList = $em
             ->getRepository('SitiowebArmyCreatorBundle:Squad')
             ->findBy(
                 [
                     'army' => $army,
                    'unitType' => $unitType
                ],
                [
                    'position' => 'ASC'
                ]
             );

        $position = (int) $request->query->get('position');

         $cpt = $position == 0 ? 1 : 0;

         foreach ($squadList as $tmpSquad) {
             if ($tmpSquad != $squad) {
                 $tmpSquad->setPosition($cpt);
                 $cpt++;
             }

             if ($cpt == $position) {
                 $cpt++;
             }
         }

        $squad->setUnitType($unitType)
             ->setPosition($position);

        $em->flush();

        return new Response('1');
    }

    /**
     * Edits an existing Squad entity.
     *
     * @Route("/{id}/update", name="squad_update")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:Squad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Squad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Squad entity.');
        }

        $entity->addEmptySquadLine(true);
        $editForm = $this->createForm(SquadType::class, $entity, ['breed' => $entity->getUnitType()->getBreed()]);
        $editForm->handleRequest($request);
        $deleteForm = $this->createDeleteForm($entity->getId());

        if ($editForm->isValid()) {
            $entity->preUpdate();
            if ($entity->getSquadLineList()->isEmpty()) {
                $em->remove($entity);
            } else {
                $em->persist($entity);
            }
            $em->flush();

            // dispatch event
            $army = $entity->getArmy();
            $this->get('event_dispatcher')
                ->dispatch(
                    'armycreator.event.squad.update',
                    new GameEvent($army->getBreed()->getGame())
                );

            return $this->redirect($this->generateUrl('army_detail', array('slug' => $entity->getArmy()->getSlug())));
        }


        return array(
            'army'      => $army,
            'entity'      => $entity,
            'currentUnitType' => $entity->getUnitType(),
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Squad entity.
     *
     * @Route("/{id}/delete", name="squad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:Squad')->find($id);
            $army = $entity->getArmy();

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Squad entity.');
            }

            $army->removeSquadList($entity);
            $em->remove($entity);
            $em->flush();

            // dispatch event
            $this->get('event_dispatcher')
                ->dispatch(
                    'armycreator.event.squad.delete',
                    new GameEvent($army->getBreed()->getGame())
                );
        }

        if (isset($army)) {
            return $this->redirect($this->generateUrl('army_detail', array('slug' => $army->getSlug())));
        } else {
            return $this->redirect($this->generateUrl('army_list'));
        }
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
            ->add('id', HiddenType::class)
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * setArmyBreadCrumb
     *
     * @access public
     * @return void
     */
    public function setArmyBreadCrumb($army)
    {
        // Breadcrumb
        if ($army->getArmyGroup() !== null) {
            $this->get("apy_breadcrumb_trail")->add(
                $army->getArmyGroup()->getName(),
                'army_group_list',
                array('groupId' =>  $army->getArmyGroup()->getId())
            );
        }
        $this->get("apy_breadcrumb_trail")->add($army->getName(), 'army_detail', array('slug' =>  $army->getSlug()));
    }
}

