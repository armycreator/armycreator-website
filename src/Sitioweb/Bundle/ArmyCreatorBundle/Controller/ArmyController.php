<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
//use JMS\SecurityExtraBundle\Annotation as Security;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserPreference;
use Sitioweb\Bundle\ArmyCreatorBundle\Event\GameEvent;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\ArmyBbcodePreferencesType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\ArmyPreferencesType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\ArmyType;

/**
 * ArmyController
 *
 * @uses BaseController
 * @Route("/army")
 * @Breadcrumb("breadcrumb.home", route="homepage")
 * @Breadcrumb("breadcrumb.army_list", route="army_list")
 *
 * @author Julien Deniau <julien@sitioweb.fr>
 */
class ArmyController extends Controller
{
    /**
     * publicListAction
     *
     * @access public
     * @return void
     *
     * @Route("/public/{page}", name="army_public_list", defaults={"page": 1})
     * @Template()
     */
    public function publicListAction($page)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $query = $em->getRepository('SitiowebArmyCreatorBundle:Army')
            ->findPublicQueryBuilder();

        $publicArmyList = $this->get('knp_paginator')
            ->paginate($query, $page, 50);

        return [
            'armyList' => $publicArmyList
        ];
    }

    /**
     * listAction
     *
     * @access public
     * @return void
     *
     * @Route("/group/{groupId}", requirements={"groupId" = "\d+"}, name="army_group_list")
     * @Route("/", name="army_list", defaults={"groupId" = null})
     * @Template()
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function listAction($groupId, Request $request)
    {
        $entityManager = $this->get('doctrine')->getManager();

        $qb = $entityManager->createQueryBuilder()
            ->select('a')
            ->from('SitiowebArmyCreatorBundle:Army', 'a')
            ->innerJoin('SitiowebArmyCreatorBundle:Breed', 'b', 'WITH', 'a.breed = b')
            ->where('a.user = :user')
            ->orderBy('b.name')
            ->addOrderBy('a.name')
            ->setParameter('user', $this->getUser());

        if (isset($groupId)) {
            $group = $entityManager->getRepository('SitiowebArmyCreatorBundle:ArmyGroup')
                ->find((int) $groupId);

            // group wanted
            if ($group) {
                $armyList = $qb->andWhere('a.armyGroup = :armyGroup')
                    ->setParameter('armyGroup', $group)
                    ->getQuery()
                    ->getResult();

                $deleteGroupForm = $this->createDeleteForm($group->getId());

                // Breadcrumb
                $this->get("apy_breadcrumb_trail")->add(
                    $group->getName(),
                    'army_group_list',
                    array('groupId' =>  $group->getId())
                );
            } else {
                $armyList = $qb->andWhere('a.armyGroup IS NULL')
                    ->getQuery()
                    ->getResult();

                $deleteGroupForm = null;
                // Breadcrumb
                $this->get("apy_breadcrumb_trail")->add(
                    $this->get('translator')->trans('army.list.no_group'),
                    'army_group_list',
                    array('groupId' =>  0)
                );
            }
        } else {
            $group = null;
            $deleteGroupForm = null;

            if ($request->query->has('all')) {
            } else {
                $qb->orderBy('a.updateDate', 'DESC')
                    ->addOrderBy('a.id', 'DESC')
                    ->setMaxResults(10);
            }

            $armyList = $qb->getQuery()->getResult();
        }

        // getting armyList
        $deleteArmyListForm = array();
        $cloneArmyListForm = [];
        foreach ($armyList as $army) {
            $deleteArmyListForm[$army->getId()] = $this->createDeleteForm($army->getId());
            $cloneArmyListForm[$army->getId()] = $this->createCloneForm($army->getId());
        }

        return array(
            'group' => $group,
            'groupId' => $groupId,
            'armyList' => $armyList,
            'cloneArmyListForm' => $cloneArmyListForm,
            'deleteArmyListForm' => $deleteArmyListForm,
            'deleteGroupForm' => $deleteGroupForm
        );
    }

    /**
     * detailPdfAction render a PDF
     *
     * @param Army $army
     * @access public
     * @return void
     *
     * @Route("/{slug}.pdf", name="army_detail_pdf")
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"slug" = "slug"}})
     */
    public function detailPdfGenerateAction(Request $request, Army $army)
    {
        //$pageUrl = $this->generateUrl('army_detail_printable', [ "slug" => $army->getSlug() ], true);
        $filename = 'ArmyCreator-' . $army->getCurrentSlug() . '.pdf';

        $html = $this->renderView(
            'SitiowebArmyCreatorBundle:Army:printableVersion.html.twig',
            $this->detailAction($army) + ['pdf' => true]
        );

        if ($request->query->has('html')) {
            return new Response($html);
        } else {
            $output = $this->get('knp_snappy.pdf')->getOutputFromHtml($html);
            return new Response(
                $output,
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'filename="'. $filename . '.pdf"'
                )
            );
        }

    }

    /**
     * printableVersionAction
     *
     * @access public
     * @return void
     *
     * @Route("/{slug}/print", name="army_detail_printable")
     * @Template()
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"slug" = "slug"}})
     */
    public function printableVersionAction(Army $army)
    {
        return $this->detailAction($army) + ['pdf' => true];
    }

    /**
     * detailAction
     *
     * @access public
     * @return void
     *
     * @Route("/{slug}/", name="army_detail")
     * @Template()
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"slug" = "slug"}})
     */
    public function detailAction(Request $request, Army $army)
    {
        // ge detail params
        $detailParams = $this->getDetailParams($army);

        // get user preferences
        $userPreferences = $this->getUserPreference();
        $form = $this->createForm(new ArmyPreferencesType(), $userPreferences);

        $userPreferencesParams = $this->getUserPreferencesParams($request, $form, $userPreferences);

        return $detailParams + $userPreferencesParams;
    }

    /**
     * getUserPreferencesParams
     *
     * @access private
     * @return void
     */
    private function getUserPreferencesParams(Request $request, $form, &$userPreferences)
    {
        // the user submitted the form
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $userPreferences = $this->getUserPreference();
            } elseif ($request->request->get('saveAsDefault') == 1) {
                // updating user general preferences
                $em = $this->get('doctrine')->getManager();
                $em->persist($userPreferences);
                $em->flush();
            }
        }

        return array(
            'preferences' => $userPreferences,
            'form' => $form->createView()
        );

    }

    /**
     * detailBbcodeAction
     *
     * @access public
     * @return void
     *
     * @Route("/{slug}/bbcode", name="army_detail_bbcode")
     * @Template()
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"slug" = "slug"}})
     */
    public function detailBbcodeAction(Request $request, Army $army)
    {
        // get detail parameters
        $detailParams = $this->getDetailParams($army);

        // get user preferences
        $userPreferences = $this->getUserPreference();
        $form = $this->createForm(new ArmyBbcodePreferencesType(), $userPreferences);

        $userPreferencesParams = $this->getUserPreferencesParams($request, $form, $userPreferences);

        // breadcrumb
        $this->get("apy_breadcrumb_trail")->add($this->get('translator')->trans('breadcrumb.bbcode'));

        return $detailParams + $userPreferencesParams;
    }

    /**
     * getDetailParams
     *
     * @param string $slug army slug
     * @access private
     * @return void
     */
    private function getDetailParams(Army $army)
    {
        $em = $this->get('doctrine')->getManager();

        // security
        if (
            $this->getUser() != $army->getUser() &&
            !$army->getIsShared() && $this->get('oneup_acl.manager') &&
            !$this->get('oneup_acl.manager')->isGranted('ROLE_ADMIN')
        ) {
            throw new AccessDeniedException('Army not shared');
        } elseif ($this->getUser() != $army->getUser()) {
            $externalUser = true;
        } else {
            $externalUser = false;
        }

        // get unit type list
        $unitTypeList = $em->getRepository('SitiowebArmyCreatorBundle:UnitType')
                            ->findByBreed($army->getBreed());

        // forms
        $deleteForm = $this->createDeleteForm($army->getId());
        $cloneForm = $this->createCloneForm($army->getId());

        $squadList = $army->getSquadList();
        $deleteSquadListForm = array();
        foreach ($squadList as $squad) {
            $deleteSquadListForm[$squad->getId()] = $this->createDeleteForm($squad->getId());
        }

        // Breadcrumb
        if ($army->getArmyGroup() !== null) {
            $this->get("apy_breadcrumb_trail")->add(
                $army->getArmyGroup()->getName(),
                'army_group_list',
                array('groupId' =>  $army->getArmyGroup()->getId())
            );
        }
        $this->get("apy_breadcrumb_trail")->add($army->getName(), 'army_detail', array('slug' =>  $army->getSlug()));

        return array(
                'army' => $army,
                'externalUser' => $externalUser,
                'unitTypeList' => $unitTypeList,
                'deleteSquadListForm' => $deleteSquadListForm,
                'deleteForm' => $deleteForm->createView(),
                'cloneForm' => $cloneForm->createView()
        );
    }

    /**
     * Displays a form to create a new Army entity.
     *
     * @Route("/action/new", name="army_new")
     * @Template("SitiowebArmyCreatorBundle:Army:edit.html.twig")
     * @Breadcrumb("breadcrumb.army_new")
     */
    public function newAction()
    {
        $entity = new Army();
        $entity->setStatus('draft');
        $preferedBreedList = $this->getUser()->getPreferedBreedList();
        if ($preferedBreedList) {
            $entity->setBreed($preferedBreedList[0]);
        }

        $form   = $this->createForm(new ArmyType($this->getUser()), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'delete_form' => null
        );
    }

    /**
     * Creates a new Army entity.
     *
     * @Route("/action/create", name="army_create")
     * @Method("post")
     * @Template("SitiowebArmyCreatorBundle:Army:new.html.twig")
     * @Breadcrumb("breadcrumb.army_new")
     */
    public function createAction(Request $request)
    {
        $entity  = new Army();
        $form    = $this->createForm(new ArmyType($this->getUser()), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->setUser($this->getUser());
            $em->persist($entity);
            $em->flush();

            // dispatch event
            $this->get('event_dispatcher')
                ->dispatch(
                    'armycreator.event.army.new',
                    new GameEvent($entity->getBreed()->getGame())
                );

            return $this->redirect($this->generateUrl('army_detail', array('slug' => $entity->getSlug())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * editAction
     *
     * @access public
     * @return void
     *
     * @Route("/{slug}/edit", name="army_edit")
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"slug" = "slug"}})
     * @Template()
     */
    public function editAction(Army $entity)
    {
        if (
            $this->getUser() != $entity->getUser() &&
            !$this->get('oneup_acl.manager')->isGranted('ROLE_ADMIN')
        ) {
            throw new AccessDeniedException();
        }

        $editForm = $this->createForm(new ArmyType($this->getUser()), $entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        // Breadcrumb
        if ($entity->getArmyGroup() !== null) {
            $this->get("apy_breadcrumb_trail")->add(
                $entity->getArmyGroup()->getName(),
                'army_group_list',
                array('groupId' =>  $entity->getArmyGroup()->getId())
            );
        }
        $this->get("apy_breadcrumb_trail")->add($entity->getName(), 'army_detail', array('slug' =>  $entity->getSlug()));
        $this->get("apy_breadcrumb_trail")->add($this->get('translator')->trans('breadcrumb.army_edit'));

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * toggleShareAction
     *
     * @access public
     * @return void
     *
     * @Route("/{slug}/toggle_share", name="army_toggle_share",
     * options={"expose": true})
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"slug" = "slug"}})
     */
    public function toggleShareAction(Request $request, Army $army)
    {
        $army->setIsShared($request->request->get('action') == 'share');
        $this->get('doctrine')->getManager()->flush();

        return new Response('ok');
    }


    /**
     * Edits an existing Army entity.
     *
     * @Route("/{slug}/update", name="army_update")
     * @Method("POST")
     * @Template("SitiowebArmyCreatorBundle:Army:edit.html.twig")
     * @Breadcrumb("breadcrumb.army_edit")
     */
    public function updateAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Army entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getId());
        $editForm = $this->createForm(new ArmyType($this->getUser()), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            // dispatch event
            $this->get('event_dispatcher')
                ->dispatch(
                    'armycreator.event.army.update',
                    new GameEvent($entity->getBreed()->getGame())
                );

            return $this->redirect($this->generateUrl('army_detail', array('slug' => $entity->getSlug())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Army entity.
     *
     * @Route("/{slug}/delete", name="army_delete")
     * @Method("POST")
     * @Breadcrumb("breadcrumb.army_delete")
     */
    public function deleteAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Army entity.');
        }

        $form = $this->createDeleteForm($entity->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();

            // dispatch event
            $this->get('event_dispatcher')
                ->dispatch(
                    'armycreator.event.army.delete',
                    new GameEvent($entity->getBreed()->getGame())
                );
        }

        return $this->redirect($this->generateUrl('army_list'));
    }

    /**
     * cloneAction
     *
     * @access public
     * @return void
     *
     * @Route("/{slug}/clone", name="army_clone")
     * @ParamConverter("army", class="SitiowebArmyCreatorBundle:Army", options={"mapping": {"slug" = "slug"}})
     * @Template()
     */
    public function cloneAction(Request $request, Army $army)
    {
        if ($this->getUser() != $army->getUser()) {
            throw new AccessDeniedException('Only the owner can clone an army');
        }

        $form = $this->createCloneForm($army->getId());
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $msg = $this->get('translator')->trans('army.fork.error_message');
            $this->get('session')->getFlashBag()->add('warning', $msg);
            return $this->redirect($this->generateUrl('army_list'));
        }

        $em = $this->get('doctrine')->getManager();
        $clone = clone $army;
        $clone->setId(null)
            ->setSlug(null)
            ->setName($army->getName() . ' ' . $this->get('translator')->trans('army.fork.append'));

        $squadList = $army->getSquadList();
        foreach ($squadList as $squad) {
            $squadClone = clone $squad;
            $squadClone->setId(null);
            $squadClone->setArmy($clone);

            $squadLineList = $squad->getSquadLineList();
            foreach ($squadLineList as $squadLine) {
                $squadLineClone = clone $squadLine;
                $squadLineClone->setId(null);
                $squadLineClone->setSquad($squadClone);

                $squadLineStuffList = $squadLine->getSquadLineStuffList();
                foreach ($squadLineStuffList as $squadLineStuff) {
                    $squadLineStuffClone = clone $squadLineStuff;
                    $squadLineStuffClone->setId(null);
                    $squadLineStuffClone->setSquadLine($squadLineClone);

                    $em->persist($squadLineStuffClone);
                }

                $em->persist($squadLineClone);
            }

            $em->persist($squadClone);
        }


        $em->persist($clone);
        $em->flush();

        // dispatch event
        $this->get('event_dispatcher')
            ->dispatch(
                'armycreator.event.army.clone',
                new GameEvent($army->getBreed()->getGame())
            );

        return $this->redirect($this->generateUrl('army_detail', array('slug' => $clone->getSlug())));
    }

    /**
     * getUserPreference
     *
     * @access private
     * @return UserPreference
     */
    private function getUserPreference()
    {
        $user = $this->getUser();
        if (!$user) {
            return new UserPreference;
        }

        $pref = $user->getPreferences();
        if ($pref) {
            return $pref;
        } else {
            return new UserPreference;
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
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * createCloneForm
     *
     * @param int $id
     * @access private
     * @return void
     */
    private function createCloneForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
