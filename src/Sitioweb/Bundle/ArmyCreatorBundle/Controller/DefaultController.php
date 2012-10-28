<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends BaseController
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
}
