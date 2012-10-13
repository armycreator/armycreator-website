<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        ladybug_dump($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'));
        ladybug_dump($this->get('security.context')->getToken()->getRoles());
        return array('name' => 'test');
    }
}
