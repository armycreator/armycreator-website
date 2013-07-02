<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\GameType;

/**
 * User controller.
 */
class UserController extends Controller
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
    }
}
