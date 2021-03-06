<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserUnitFeature;
use Sitioweb\Bundle\ArmyCreatorBundle\Event\GameEvent;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\CollectionType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\UserUnitFeatureType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Collection controller.
 *
 * @Breadcrumb("breadcrumb.home", route="homepage")
 * @Breadcrumb("main_menu.my_collection", route="user_collection")
 */
class CollectionController extends Controller
{
    /**
     * collectionAction
     *
     * @access public
     * @return void
     *
     * @Route("/collection", name="user_collection")
     * @Template()
     */
    public function collectionAction()
    {
        $em = $this->getDoctrine()->getManager();

        $gameList = $em->getRepository('SitiowebArmyCreatorBundle:Game')->findAll();

        return array(
            'gameList' => $gameList,
        );
    }

    /**
     * collectionEditAction
     *
     * @access public
     * @return void
     *
     * @Route("/collection/{breed}", name="user_collection_edit")
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Template()
     * @Breadcrumb("{breed.name}")
     */
    public function collectionEditAction(Request $request, Breed $breed)
    {
        $user = $this->get('user_service')->getArmyCreatorUser();
        $unitList = $this->get('doctrine')
                        ->getRepository('SitiowebArmyCreatorBundle:Unit')
                        ->findBy(['breed' => $breed]);

        //$user->addEmptyUserHasUnitLine($breed);
        $uhuList = $user->getBreedUserHasUnitList($breed);
        $form = $this->createForm(CollectionType::class, ['userHasUnitList' => $uhuList]);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->get('doctrine')
                ->getManager();

            $uhuList = $form->getData()['userHasUnitList'];
            foreach ($uhuList as $uhu) {
                if ($uhu->getNumber() > 0) {
                    $user->addUserHasUnitList($uhu);
                    $em->persist($uhu);
                } else {
                    $user->removeUserHasUnitList($uhu);
                    $em->remove($uhu);
                }
            }
            $em->flush();

            // dispatch event
            $this->get('event_dispatcher')
                ->dispatch(
                    'armycreator.event.collection.edit',
                    new GameEvent($breed->getGame())
                );
        }

        $unitFeatureList = $this->get('doctrine')
            ->getRepository('SitiowebArmyCreatorBundle:UserUnitFeature')
            ->findBy([ 'user' => $user, 'unit' => $unitList ]);

        $indexedUnitFeatureList = [];
        foreach ($unitFeatureList as $unitFeature) {
            $indexedUnitFeatureList[$unitFeature->getUnit()->getId()] = $unitFeature;
        }

        return [
            'breed' => $breed,
            'unitList' => $unitList,
            'form' => $form->createView(),
            'unitFeatureList' => $indexedUnitFeatureList,
        ];
    }

    /**
     * collectionContainsAction
     *
     * @access public
     * @return void
     *
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Route("/collection/{breed}/contains", name="user_collection_contains")
     */
    public function collectionContainsAction(Breed $breed)
    {
        $user = $this->get('user_service')->getArmyCreatorUser();
        $user->addCollectionList($breed);
        $this->get('doctrine')->getManager()->flush();

        // dispatch event
        $this->get('event_dispatcher')
            ->dispatch(
                'armycreator.event.collection.contains',
                new GameEvent($breed->getGame())
            );

        $url = $this->get('router')
                ->generate('user_collection_edit', ['breed' => $breed->getSlug()]);

        return $this->redirect($url);
    }

    /**
     * collectionRemoveAction
     *
     * @access public
     * @return void
     *
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
     * @Route("/collection/{breed}/remove", name="user_collection_remove")
     */
    public function collectionRemoveAction(Breed $breed)
    {
        $user = $this->get('user_service')->getArmyCreatorUser();
        $user->removeCollectionList($breed);
        $this->get('doctrine')->getManager()->flush();

        // dispatch event
        $this->get('event_dispatcher')
            ->dispatch(
                'armycreator.event.collection.contains',
                new GameEvent($breed->getGame())
            );

        $url = $this->get('router')
                ->generate('user_collection');

        return $this->redirect($url);
    }

    /**
     * unitFeatureEditAction
     *
     * @access public
     * @return void
     *
     * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breedSlug" = "slug"}})
     * @ParamConverter("unit", class="SitiowebArmyCreatorBundle:Unit", options={"mapping": {"unit" = "id"}})
     * @Route("/collection/{breedSlug}/unit_feature/{unit}", name="unit_feature_edit")
     * @Template
     * @Breadcrumb("{breed.name}", routeName="user_collection_edit", routeParameters={"breed"="{breedSlug}"})
     * @Breadcrumb("{unit.name}")
     */
    public function unitFeatureEditAction(Request $request, Breed $breed, Unit $unit)
    {
        $user = $this->get('user_service')->getArmyCreatorUser();
        $unitFeature = $this->get('doctrine')
            ->getRepository('SitiowebArmyCreatorBundle:UserUnitFeature')
            ->findOneBy([ 'user' => $user, 'unit' => $unit ]);

        if (!$unitFeature) {
            $unitFeature = new UserUnitFeature;
            $unitFeature->setUser($user)
                ->setUnit($unit);
        }

        $editForm = $this->createForm(UserUnitFeatureType::class, $unitFeature, ['breed' => $breed]);

        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            // dirty fix because description object are compared by reference, not by value
            // @see http://doctrine-orm.readthedocs.org/en/latest/reference/basic-mapping.html
            $feature = $unitFeature->getFeature();
            if (is_object($feature)) {
                $unitFeature->setFeature(clone $feature);
            }

            $em = $this->get('doctrine.orm.default_entity_manager');
            $em->persist($unitFeature);
            $em->flush();

            // dispatch event
            $this->get('event_dispatcher')
                ->dispatch(
                    'armycreator.event.unit_feature.edit',
                    new GameEvent($breed->getGame())
                );

            return $this->redirect($this->generateUrl('user_collection_edit', ['breed' => $breed->getSlug()]));
        }


        return [
            'unit' => $unit,
            'form' => $editForm->createView(),
        ];
    }
}
