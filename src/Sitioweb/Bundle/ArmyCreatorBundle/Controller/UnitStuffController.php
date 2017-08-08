<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\UnitStuffMultiType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\UnitStuffType;

/**
 * UnitStuff controller.
 *
 * @ParamConverter("game", class="SitiowebArmyCreatorBundle:Game", options={"mapping": {"game" = "code"}})
 * @ParamConverter("breed", class="SitiowebArmyCreatorBundle:Breed", options={"mapping": {"breed" = "slug"}})
 * @Route("/admin/{game}/{breed}")
 * @Breadcrumb("breadcrumb.home", route="homepage")
 * @Breadcrumb("breadcrumb.admin.index", route="admin_game")
 */
class UnitStuffController extends Controller
{
    /**
     * Displays a form to create a new UnitStuff entity.
     *
     * @Route("/{unit}/stuff", name="unitstuff_new")
     * @Template()
     * @ParamConverter("unit", class="SitiowebArmyCreatorBundle:Unit", options={"mapping": {"unit" = "slug"}})
     */
    public function newAction(Request $request, Breed $breed, Unit $unit)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $this->get("apy_breadcrumb_trail")->add(
            $breed->getGame()->getName(),
            'admin_breed',
            ['game' =>  $breed->getGame()->getCode()]
        );
        $this->get("apy_breadcrumb_trail")->add(
            $breed->getName(),
            'admin_breed_show',
            ['game' =>  $breed->getGame()->getCode(), 'breed' => $breed->getSlug()]
        );
        $this->get("apy_breadcrumb_trail")->add(
            $this->get('translator')->trans('breadcrumb.admin.stuff'),
            'unitstuff_new',
            [
                'game' =>  $breed->getGame()->getCode(),
                'breed' => $breed->getSlug(),
                'unit' => $unit->getSlug(),
            ]
        );

        $newUnitStuffList = $this->getBreedUnitStuffList($unit);
        $form = $this->createForm(new UnitStuffMultiType($breed), $newUnitStuffList);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine')
                ->getManager();
            foreach ($newUnitStuffList as $newUnitStuff) {
                if ($newUnitStuff->getVisible()) {
                    $unit->addUnitStuffList($newUnitStuff);
                    $em->persist($newUnitStuff);
                } else {
                    $refExists = $em->getRepository('SitiowebArmyCreatorBundle:SquadLineStuff')
                        ->findOneByUnitStuff($newUnitStuff);
                    if ($refExists) {
                        $newUnitStuff->setVisible(false);
                        $em->persist($newUnitStuff);
                    } else {
                        $unit->removeUnitStuffList($newUnitStuff);
                        $em->remove($newUnitStuff);
                    }
                }
            }

            $em->flush();

            return $this->redirect($this->getArmyShowUrl($breed, $unit));
        }

        return array(
            'unit' => $unit,
            'form'   => $form->createView(),
        );
    }

    /**
     * Deletes a UnitStuff entity.
     *
     * @Route("/{id}", name="unitstuff_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id, Breed $breed)
    {
        if (!$this->get('oneup_acl.manager')->isGranted('EDIT', $breed)) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        $unit = null;

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SitiowebArmyCreatorBundle:UnitStuff')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UnitStuff entity.');
            }
            $unit = $entity->getUnit();

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->getArmyShowUrl($breed, $unit));
    }

    /**
     * getBreedUnitStuffList
     *
     * @param Unit $unit
     * @access private
     * @return array
     */
    private function getBreedUnitStuffList(Unit $unit)
    {
        $breed = $unit->getBreed();
        $stuffList = array_merge(
            $breed->getStuffList()->toArray(),
            $breed->getGame()->getStuffList()->toArray()
        );

        $usList = [];
        foreach ($stuffList as $stuff) {
            $unitStuff = new UnitStuff();
            $unitStuff->setUnit($unit)
                ->setStuff($stuff)
                ->setPoints($stuff->getDefaultPoints())
                ->setAuto($stuff->getDefaultAuto());
            $unitStuff->setVisible(false);
            $usList[$stuff->getId()] = $unitStuff;
        }

        foreach ($unit->getUnitStuffList() as $unitStuff) {
            $stuff = $unitStuff->getStuff();
            $unitStuff->setVisible(true);
            $usList[$stuff->getId()] = $unitStuff;
        }

        return $usList;
    }

    /**
     * Creates a form to delete a UnitStuff entity by id.
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
     * getArmyShowUrl
     *
     * @param Breed $breed
     * @param Unit $unit
     * @access private
     * @return string
     */
    private function getArmyShowUrl(Breed $breed, Unit $unit)
    {
        $url = $this->generateUrl(
                'admin_breed_unit',
                array(
                    'breed' => $breed->getSlug(),
                    'game' => $breed->getGame()->getCode()
                    )
                );

        $url .= '#unit-' . $unit->getSlug();

        return $url;
    }
}
