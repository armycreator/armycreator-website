<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * ArmyController
 * 
 * @uses BaseController
 * @Route("/army")
 *
 * @author Julien Deniau <julien@sitioweb.fr> 
 */
class ArmyController extends Controller
{
    /**
     * listAction
     *
     * @access public
     * @return void
     *
     * @Route("/group/{groupId}", requirements={"groupId" = "\d+"}, name="army_group_list")
     * @Route("/", name="army_list", defaults={"groupId" = null})
     * @Template()
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     */
    public function listAction($groupId)
    {
        if ($groupId > 0) {
            $group = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:ArmyGroup')->find((int) $groupId);
        } else {
            $group = null;
        }
        
        return array(
            'group' => $group
        );
    }

    /**
     * detailAction
     *
     * @access public
     * @return void
     *
     * @Route("/", name="army_detail")
     * @Template()
     */
    public function detailAction()
    {
        return array();
    }
}

