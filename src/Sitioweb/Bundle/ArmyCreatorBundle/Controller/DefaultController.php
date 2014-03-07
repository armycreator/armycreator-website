<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * DefaultController
 *
 * @uses Controller
 * @Route("/")
 * @Breadcrumb("breadcrumb.home", route="homepage")
 *
 * @author Julien DENIAU <julien.deniau@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $this->getUser();
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->authenticatedIndex();
        } else {
            return [];
        }
    }

    /**
     * authenticatedIndex
     *
     * @access public
     * @return void
     */
    public function authenticatedIndex() {
        $params = [];

        $params['lastArmy'] = $this->container
            ->get('doctrine')
            ->getManager()
            ->getRepository('SitiowebArmyCreatorBundle:Army')
            ->findOneBy(
                ['user' => $this->getUser()],
                ['updateDate' => 'DESC']
            );
        return $this->render(
            'SitiowebArmyCreatorBundle:Default:authenticatedIndex.html.twig',
            $params
        );
    }

    /**
     * getHeader
     *
     * @access public
     * @return string
     *
     * @Route("/header", name="header")
     */
    public function getHeader() {
        $am = $this->get('assetic.asset_manager');
        $names = $am->getNames();
        $cssList = [];
        $jsList = [];
        foreach ($names as $nameTmp) {
            $name = $am->get($nameTmp)->getTargetPath();
            if (strpos($name, 'global') !== false) {
                if (substr($name, 0, 3) === 'js/') {
                    $jsList[] = $name;
                } else {
                    $cssList[] = $name;
                }
            }
        }

        return $this->get('templating')
            ->render(
                'SitiowebArmyCreatorBundle::header.html.twig',
                [
                    'ads' => true,
                    'moreCssList' => $cssList,
                    'moreJsList' => $jsList,
                ]
            );
    }

    /**
     * getFooter
     *
     * @access public
     * @return string
     */
    public function getFooter() {
        return $this->get('templating')
            ->render(
                'SitiowebArmyCreatorBundle::footer.html.twig'
            );
    }
}
