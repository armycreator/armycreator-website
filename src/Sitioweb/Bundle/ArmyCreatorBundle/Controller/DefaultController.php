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
 * @Breadcrumb("Home", route="homepage")
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
            return array('test' => 'test');
        }
    }

    /**
     * authenticatedIndex
     *
     * @access public
     * @return void
     */
    public function authenticatedIndex() {
        return $this->render('SitiowebArmyCreatorBundle:Default:authenticatedIndex.html.twig', array());
    }

    /**
     * getHeader
     *
     * @access public
     * @return string
     */
    public function getHeader() {
        return $this->get('templating')->render('SitiowebArmyCreatorBundle::header.html.twig', array());
    }

    /**
     * getFooter
     *
     * @access public
     * @return string
     */
    public function getFooter() {
        return $this->get('templating')->render('SitiowebArmyCreatorBundle::footer.html.twig', array());
    }
}
