<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

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
class ArmyController
{
    /**
     * listAction
     *
     * @access public
     * @return void
     *
     * @Route("/group/{groupId}", name="army_group_list")
     * @Route("/", name="army_list", defaults={"groupId" = null})
     * @Template()
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     */
    public function listAction($groupId)
    {
        if ($groupId > 0) {
            $group = $this->get('doctrine')->getManager()->getRepository('\Sitioweb\Bundle\ArmyCreatorBundle\Entity\ArmyGroup')->find($groupId);
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

